<?php

namespace App\Http\Controllers\Agent;

use App\Enums\Agent\AgentRoles;
use App\Enums\Business\CompanyType;
use App\Enums\Payment\PaymentTerms;
use App\Enums\Payment\TradeTerms;
use App\Enums\Person\AccountStatus;
use App\Enums\ProspectLocation;
use App\Enums\ProspectType;
use App\Enums\PurchaseFrequency;
use App\Enums\PurchasePolicy;
use App\Http\Controllers\Controller;
use App\Http\Requests\Agent\PurchaseRequirement\CreatePurchaseRequirementRequest;
use App\Http\Requests\Agent\PurchaseRequirement\UpdatePurchaseRequirement;
use App\Models\Business;
use App\Models\Category;
use App\Models\Language;
use App\Models\Person;
use App\Models\Metric;
use App\Models\Country;
use App\Models\TimeZone;
use App\Models\HsCode;
use App\Models\NaicCode;
use App\Models\SaicCode;
use App\Repositories\Business\BusinessRepositoryInterface;
use App\Repositories\Person\PersonRepositoryInterface;
use App\Repositories\PurchaseRequirement\PurchaseRequirementRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\PurchaseRequirement;

use App\Enums\Business\BusinessType;
use App\Enums\Designations\DesignationType;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PHPUnit\Framework\Constraint\Count;

class PurchaseRequirementsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $role = auth('agent')->user()->role->value;

        $purchase_requirements = PurchaseRequirement::with('person');
        if($role !== AgentRoles::agent)
        {
            $people = Person::select(\DB::raw("CONCAT(name, ' (', email, ')') AS name"), 'id')->pluck('name', 'id');
        }
        else
        {
            $people = Person::select(\DB::raw("CONCAT(name, ' (', email, ')') AS name"), 'id')->where('agent_id', auth('agent')->user()->id)->pluck('name', 'id');
            $purchase_requirements = $purchase_requirements->whereHas('person', function ($q){
                $q->where('agent_id', '=',auth('agent')->user()->id);
                $q->where('agent_id', '!=', null);
            });
        }

        $countries = Country::pluck('name', 'id');

        if($request->has('keyword'))
        {
            $purchase_requirements = $purchase_requirements->where('product', 'like',  '%'.$request->get('keyword').'%');
        }

        if($request->has('person_id'))
        {
            $purchase_requirements = $purchase_requirements->where('person_id', $request->get('person_id'));
        }

        if($request->has('category_id'))
        {
            $purchase_requirements = $purchase_requirements->where('category_id', $request->get('category_id'));
        }

        if($request->has('date'))
        {
            $purchase_requirements = $purchase_requirements->whereDate('created_at', $request->get('date'));
        }

        if($request->has('country_id'))
        {
            $country = Country::findOrFail($request->get('country_id'));
            $people = $country->people->pluck('id');
            $purchase_requirements = $purchase_requirements->whereIn('person_id', $people);
        }

        if($request->has('time_slot'))
        {
            if ($request->get('time_slot') == 'only_available'){
                $purchase_requirements = $purchase_requirements->whereHas('timeslots');
            }
        }

        $purchase_requirements = $purchase_requirements->orderBy('id', 'desc')->paginate(10)->withQueryString();

        return view('agent.purchaserequirements.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $people = Person::select(\DB::raw("CONCAT(name, ' (', email, ')') AS name"), 'id')->where('status', AccountStatus::Verified);
        $role = auth('agent')->user()->role->value;
        if($role === AgentRoles::agent || $role === AgentRoles::translator)
        {
            $people = $people->where('agent_id', auth('agent')->user()->id);
        }

        $people = $people->pluck('name', 'id');
        $businesses = Business::pluck('name', 'id');
        $phoneCodes = Country::pluck('phonecode', 'id');
        $metrics = Metric::pluck('name', 'id');
        $company_types = CompanyType::asSelectArray();
        $purchasePolicies = PurchasePolicy::asSelectArray();
        $purchaseFrequencies = PurchaseFrequency::asSelectArray();
        $timezones = TimeZone::pluck('name', 'id');
        $countries = Country::pluck('name', 'id');
        $hs_codes = HsCode::select(\DB::raw("CONCAT(code, ' (', name, ')') AS name"), 'id')->pluck('name', 'id');
        $naic_codes = NaicCode::select(\DB::raw("CONCAT(code, ' (', name, ')') AS name"), 'id')->pluck('name', 'id');
        $saic_codes = SaicCode::select(\DB::raw("CONCAT(code, ' (', name, ')') AS name"), 'id')->pluck('name', 'id');
        $business_types = BusinessType::asSelectArray();
        $designations = DesignationType::asSelectArray();
        $prospectLocations = ProspectLocation::asSelectArray();
        $prospectTypes = ProspectType::asSelectArray();
        $paymentTerms = PaymentTerms::asSelectArray();
        $tradeTerms = TradeTerms::asSelectArray();
        $languages = Language::pluck('name', 'id');

        return view('agent.purchaserequirements.create', get_defined_vars());
    }

    public function store(CreatePurchaseRequirementRequest $request, PersonRepositoryInterface $personRepository, BusinessRepositoryInterface $businessRepository, PurchaseRequirementRepositoryInterface $purchaseRequirementRepository)
    {
        try {
            DB::beginTransaction();
            $person = null;
            if (!$request->has('person_id')) {
                $person = $personRepository->create(array_merge($request->validated(), [
                    'source' => 'agent'
                ]));
                $businessRepository->create($request->validated(), $person);
            }
            else
            {
                $person = Person::find($request->validated()['person_id']);
            }

            $data = $request->validated();
            $purchase_requirement = $purchaseRequirementRepository->create($data, $person);

            DB::commit();
            return redirect()->route('agent.purchase_requirements.index')->with('success', 'Purchase Requirement created successfully!');
        } catch (\Exception $exception) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Something went wrong!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $purchase_requirement)
    {
        $business_types = BusinessType::asSelectArray();
        $countries = Country::pluck('name', 'id');

        return view('agent.purchaserequirements.show', get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $purchase_requirement)
    {
        $people = Person::select(\DB::raw("CONCAT(name, ' (', email, ')') AS name"), 'id')->pluck('name', 'id');
        $countries = Country::pluck('name', 'id');
        $metrics = Metric::pluck('name', 'id');
        $hs_codes = HsCode::select(\DB::raw("CONCAT(code, ' (', name, ')') AS name"), 'id')->pluck('name', 'id');
        $purchasePolicies = PurchasePolicy::asSelectArray();
        $purchaseFrequencies = PurchaseFrequency::asSelectArray();
        $prospectLocations = ProspectLocation::asSelectArray();
        $prospectTypes = ProspectType::asSelectArray();
        $paymentTerms = PaymentTerms::asSelectArray();
        $tradeTerms = TradeTerms::asSelectArray();

        return view('agent.purchaserequirements.edit', get_defined_vars());
    }

    public function update(UpdatePurchaseRequirement $request, $purchase_requirement, PurchaseRequirementRepositoryInterface $purchaseRequirementRepository) {

        $data = $request->validated();

        $purchaseRequirementRepository->update($data, $purchase_requirement->id);
        return redirect()->route('agent.purchase_requirements.index')->with('success', 'Purchase Requirement updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($purchase_requirement)
    {
        if ($purchase_requirement->delete()) {
            return redirect()->route('agent.purchase_requirements.index')->with('success', 'Purchase Requirement deleted successfully!');
        }

        return back()->with('error', 'Something went wrong!');
    }
}
