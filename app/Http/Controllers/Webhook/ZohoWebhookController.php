<?php

namespace App\Http\Controllers\Webhook;

use App\Enums\Business\BusinessType;
use App\Enums\Business\CompanyType;
use App\Enums\Person\AccountSourceTypes;
use App\Enums\Person\AccountStatus;
use App\Enums\ProspectType;
use App\Http\Controllers\Controller;
use App\Http\Resources\PersonResource;
use App\Models\Category;
use App\Models\Country;
use App\Models\Language;
use App\Models\TimeZone;
use App\Repositories\Business\BusinessRepositoryInterface;
use App\Repositories\Person\PersonRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ZohoWebhookController extends Controller
{
    private $personRepository;
    private $businessRepository;

    public function __construct(PersonRepositoryInterface $personRepository, BusinessRepositoryInterface $businessRepository){
        $this->personRepository = $personRepository;
        $this->businessRepository = $businessRepository;
    }

    public function handleWebhook(Request $request){
        Log::info('new zoho webhook recieved', $request->all());
        try
        {
            switch($request->notification_type)
            {
                case "supplier":
                    $this->handleSupplierCreated($request->all());
                    break;
                case "buyer":
                    $this->handleBuyerCreated($request->all());
                    break;
            }
        }
        catch(\Exception $exception)
        {
            Log::error('zoho webhook failed', ['message' => $exception->getMessage()]);
        }

        return $this->webhookHandled();
    }

    public function handleSupplierCreated($data)
    {
        //validate
        $validator = Validator::make($data, [
            'business_name' => 'required|string',
            'country' => 'required|string',
            'preferred_languages' => 'required|string',
            'city' => 'nullable|string',
            'street' => 'nullable|string',
            'state' => 'nullable|string',
            'business_type' => 'required|string',
            'company_type' => 'required|string',
            'name' => 'required|string',
            'timeZone' => 'required|string',
            'title' => 'nullable|string',
            'email' => 'required|email',
            'category' => 'required|string',
            'website' => 'nullable|string',
            'linkedin' => 'nullable|string',
            'facebook' => 'nullable|string',
            'instagram' => 'nullable|string',
            'hscode' => 'nullable|string',
        ]);

        $validator->validate();

        $person = $this->personRepository->getByEmail($data['email']);
        if($person)
        {
            throw new \Exception('account exists');
        }

        //map
        $data = $this->mapFields($validator->validated(),'supplier');

        //create
        DB::beginTransaction();
        try
        {
            $person = $this->personRepository->create(
                array_merge(
                    $data['person_data'],
                    [
                        'email_verified_at' => Carbon::now(),
                        'source' => AccountSourceTypes::Zoho,
                        'status' => AccountStatus::OnBoarding
                    ]
                ), null, false);

            $this->businessRepository->create($data['business_data'], $person);
            DB::commit();
            return true;
        }
        catch (\Exception $exception)
        {
            DB::rollBack();
        }

        return false;
    }

    public function handleBuyerCreated($data)
    {
        //validate
        $validator = Validator::make($data, [
            'business_name' => 'required|string',
            'country' => 'required|string',
            'preferred_languages' => 'required|string',
            'city' => 'nullable|string',
            'street' => 'nullable|string',
            'state' => 'nullable|string',
            'business_type' => 'required|string',
            'company_type' => 'required|string',
            'name' => 'required|string',
            'timeZone' => 'required|string',
            'title' => 'nullable|string',
            'email' => 'required|email',
            'category' => 'required|string',
            'website' => 'nullable|string',
            'linkedin' => 'nullable|string',
            'facebook' => 'nullable|string',
            'instagram' => 'nullable|string',
            'hscode' => 'nullable|string',
        ]);

        $validator->validate();

        $person = $this->personRepository->getByEmail($data['email']);
        if($person)
        {
            throw new \Exception('account exists');
        }

        //map
        $data = $this->mapFields($validator->validated(),'buyer');

        //create
        DB::beginTransaction();
        try
        {
            $person = $this->personRepository->create(
                array_merge(
                    $data['person_data'],
                    [
                        'email_verified_at' => Carbon::now(),
                        'source' => AccountSourceTypes::Zoho,
                        'status' => AccountStatus::OnBoarding
                    ]
                ), null, false);

            $this->businessRepository->create($data['business_data'], $person);
            DB::commit();
            return true;
        }
        catch (\Exception $exception)
        {
            DB::rollBack();
            throw $exception;
        }

        return false;
    }

    private function mapFields($data, $intent){

        $timezone = TimeZone::whereRaw("name LIKE '%". $data['timeZone']."%'")->firstOrFail();
        $country = Country::whereRaw("name LIKE '%". $data['country']."%'")->firstOrFail();
        $category = $this->getCategory($data['category']);
        $businessType = $this->getBusinessType($data['business_type']);
        $companyType = $this->getCompanyType($data['company_type']);
        $languages = $this->getLanguages($data['preferred_languages']);

        $prospectType = $intent === 'supplier' ? ProspectType::Buyers : ProspectType::Supplier;

        $mappedData = [];
        $mappedData['person_data'] = [
            'name' => $data['name'],
            'email' => $data['email'],
            'timezone_id' => $timezone->id,
            'country_id' => $country->id,
            'looking_for' => $prospectType,
            'looking_for_category' => $category->id,
            'languages' => $languages
        ];

        $mappedData['business_data'] = [
            'business_name' => $data['business_name'],
            'type_id' => $businessType,
            'company_type_id' => $companyType,
            'current_importer' => isset($data['current_importer']) ? 'yes' : 'no',
            'address' => (isset($data['address']) && $data['address']) ? $data['address'] : $country->name,
            'city' => (isset($data['city']) && $data['city']) ? $data['city'] : $country->name,
            'state' => (isset($data['state']) && $data['state']) ? $data['state'] : $country->name,
            'country_id' => $country->id,
            'website' => isset($data['website']) ? $data['website'] : null,
            'linkedin' => isset($data['linkedin']) ? $data['linkedin'] : null,
            'facebook' => isset($data['facebook']) ? $data['facebook'] : null,
            'instagram' => isset($data['instagram']) ? $data['instagram'] : null,
        ];

        return $mappedData;
    }

    private function getHsCode($input)
    {
        //input format unknown
    }

    private function getLanguages($input)
    {
        $languages = explode(';', $input);
        $found = [];

        foreach($languages as $value)
        {
            $language = Language::whereRaw("name LIKE '%". $value."%'")->first();
            if($language)
            {
                array_push($found, $language->id);
            }
        }

        return $found;
    }

    private function getCategory($input)
    {
        $categories = explode(';', $input);
        $found = null;

        foreach($categories as $value)
        {
            $category = Category::whereRaw("name LIKE '%". $value."%'")->first();
            if($category)
            {
                $found = $category;
                break;
            }
        }

        if(!$found)
        {
            throw  new \Exception('category not found');
        }

        return $found;
    }

    private function getCompanyType($input)
    {
        $input = strtolower($input);
        $input = preg_replace('!\s+!', ' ', $input);
        $input = str_replace(' ', '_', $input);
        $types =  CompanyType::asArray();
        $found = null;
        foreach($types as $key => $value)
        {
            if($input === strtolower($key))
            {
                $found = $value;
            }
        }

        if(!$found)
        {
            throw new \Exception('company type not found');
        }

        return $found;
    }

    private function getBusinessType($input)
    {
        $input = strtolower($input);
        $input = preg_replace('!\s+!', ' ', $input);
        $input = str_replace(' ', '_', $input);
        $types =  BusinessType::asArray();
        $found = null;
        foreach($types as $key => $value)
        {
            if($input === strtolower($key))
            {
                $found = $value;
                break;
            }
        }

        if(!$found)
        {
            throw new \Exception('business type not found');
        }

       return $found;
    }

    public function webhookHandled()
    {
        return response()->json('success',200);
    }

}
