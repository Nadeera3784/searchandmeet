<?php

namespace App\Http\Controllers\Agent;

use App\Enums\Agent\AgentRoles;
use App\Enums\Business\AnnualRevenueBracket;
use App\Enums\Business\CompanyType;
use App\Enums\Business\EmployeeCountBracket;
use App\Enums\Person\AccountStatus;
use App\Events\PersonStatusCheck;
use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Language;
use App\Models\Metric;
use App\Models\Country;
use App\Http\Requests\Agent\Person\CreatePersonRequest;
use App\Http\Requests\Agent\Person\UpdatePersonRequest;
use App\Models\Person;
use App\Models\PreferredTime;
use App\Models\TimeZone;
use App\Models\User;
use App\Models\NaicCode;
use App\Models\SaicCode;
use App\Repositories\Person\PersonRepositoryInterface;
use App\Repositories\Business\BusinessRepositoryInterface;
use App\Enums\Business\BusinessType;
use App\Enums\Designations\DesignationType;
use Illuminate\Http\Request;
use App\Imports\PersonImport;


class PeopleController extends Controller
{

    private $repository;
    private $businessRepository;

    public function __construct(PersonRepositoryInterface $repository, BusinessRepositoryInterface $businessRepository)
    {
        $this->repository = $repository;
        $this->businessRepository = $businessRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $role = auth('agent')->user()->role->value;
        $people = Person::with('purchase_requirements','agent');
        $countries = Country::pluck('name', 'id');

        if($request->has('status'))
        {
            switch($request->status)
            {
                case "unverified":
                    $people = $people->where('status', AccountStatus::Unverified);
                    break;
                case "suspended":
                    $people = $people->where('status', AccountStatus::Suspended);
                    break;
                case "onboarding":
                    $people = $people->where('status', AccountStatus::OnBoarding);
                    break;
            }
        }
        else
        {
            if($role === AgentRoles::agent)
            {
                $people = $people->where('agent_id', auth('agent')->user()->id);
            }
        }

        if($request->has('email'))
        {
            $people = $people->where('email', $request->get('email'));
        }

        if($request->has('keyword'))
        {

            $people = $people->where('name', 'like',  '%'.$request->get('keyword').'%')
                                            ->orWhere('email', 'like',  '%'.$request->get('keyword').'%');

        }

        if($request->has('looking_for'))
        {
            $people = $people->where('looking_for', $request->get('looking_for'));
        }

        if($request->has('source'))
        {
            $people = $people->where('source', $request->get('source'));
        }

        if($request->has('country_id'))
        {
            $people = $people->where('country_id', $request->get('country_id'));
        }

        $people = $people->orderBy('created_at', 'desc')->paginate()->withQueryString();

        return view('agent.people.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::pluck('name', 'id');
        $phoneCodes = Country::pluck('phonecode', 'id');
        $business_types = BusinessType::asSelectArray();
        $designations = DesignationType::asSelectArray();
        $metrics = Metric::pluck('name', 'id');
        $timezones = TimeZone::pluck('name', 'id');
        $company_types = CompanyType::asSelectArray();
        $languages = Language::pluck('name', 'id');
        $naic_codes = NaicCode::select(\DB::raw("CONCAT(code, ' (', name, ')') AS name"), 'id')->pluck('name', 'id');
        $saic_codes = SaicCode::select(\DB::raw("CONCAT(code, ' (', name, ')') AS name"), 'id')->pluck('name', 'id');
        $employeeCountBrackets = EmployeeCountBracket::asSelectArray();
        $annualRevenueBrackets = AnnualRevenueBracket::asSelectArray();
        $preferredTimes = PreferredTime::pluck('time as name', 'id');

        return view('agent.people.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePersonRequest $request)
    {
        $person = $this->repository->create(
            array_merge($request->validated(), [
                'source' => 'agent'
            ]), auth('agent')->user()->id);

        if($person) {
            $business = $this->businessRepository->create($request->validated(), $person);
        }

        return redirect()->route('agent.people.index')->with('success', 'Person added successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $person
     * @return \Illuminate\Http\Response
     */
    public function show($person)
    {
        $designations = DesignationType::asSelectArray();
        $business_types = BusinessType::asSelectArray();
        $company_types = CompanyType::asSelectArray();
        $phoneCodes = Country::pluck('phonecode', 'id');
        $countries = Country::pluck('name', 'id');
        $timezones = TimeZone::pluck('name', 'id');
        $languages = Language::pluck('name', 'id');

        return view('agent.people.show', get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $person
     * @return \Illuminate\Http\Response
     */
    public function edit($person)
    {
        $countries = Country::pluck('name', 'id');

        $business_types = BusinessType::asSelectArray();
        $designations = DesignationType::asSelectArray();
        $company_types = CompanyType::asSelectArray();
        $phoneCodes = Country::pluck('phonecode', 'id');
        $timezones = TimeZone::pluck('name', 'id');
        $languages = Language::pluck('name', 'id');
        $naic_codes = NaicCode::select(\DB::raw("CONCAT(code, ' (', name, ')') AS name"), 'id')->pluck('name', 'id');
        $saic_codes = SaicCode::select(\DB::raw("CONCAT(code, ' (', name, ')') AS name"), 'id')->pluck('name', 'id');
        $employeeCountBrackets = EmployeeCountBracket::asSelectArray();
        $annualRevenueBrackets = AnnualRevenueBracket::asSelectArray();
        $preferredTimes = PreferredTime::pluck('time as name', 'id');
        $agents = User::select(\DB::raw("CONCAT(name, ' (', email, ')') AS name"), 'id')->where('role', AgentRoles::agent)->pluck('name', 'id');

        return view('agent.people.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $person
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePersonRequest $request, $person)
    {
        $this->repository->update($request->validated(), $person->id);
        $person = $this->repository->getById($person->id);
        if($person) {
            if(isset($person->business)) {
                $business = $this->businessRepository->update($request->validated(), $person->business->id);
            }
            else {
                $business = $this->businessRepository->create($request->validated(), $person);
            }
        }

        if($request->agent_id)
        {
            PersonStatusCheck::dispatch($person);
        }

        return redirect()->route('agent.people.index')->with('success', 'Person updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $person
     * @return \Illuminate\Http\Response
     */
    public function destroy($person)
    {
        $person = $this->repository->delete($person->id);
        return redirect()->route('agent.people.index')->with('success', 'Person deleted successfully!');
    }

    public function verify($person)
    {
        if($person->status === AccountStatus::OnBoarding)
        {
            if(!Business::where('person_id', $person->id)->exists())
            {
                return redirect()->back()->with('error', 'Person doesn\'t have a business, please update details to verify person!');
            }
        }

        $person = $this->repository->update([
            'agent_id' => auth('agent')->user()->id,
        ], $person->id);

        PersonStatusCheck::dispatch($person);
        return redirect()->route('agent.people.index')->with('success', 'Person status updated successfully!');
    }

    public function unsuspend($person)
    {
        $this->repository->update([
            'status' => AccountStatus::Verified
        ], $person->id);

        return redirect()->route('agent.people.index')->with('success', 'Person status updated successfully!');
    }

    public function import(){

        return view('agent.people.import');
    }

    public function import_store(Request $request){

        $native_errors = 0;


        $this->validate($request, [
            'file' => 'required|file|mimes:xls,xlsx'
        ]);

     	$file = $request->file;

        $import_instance  = new PersonImport($this->repository, $this->businessRepository);

        $import_instance->import($file);

        if($import_instance->failures()){
            foreach($import_instance->failures() as $failure){
                $native_errors++;
            }
        }


        if($native_errors > 0){
            return redirect()->route('agent.people.index')->with('error', $native_errors ."  of records has been failed");
        }

        $number_of_success_imports = $import_instance->getCountImports();

        $number_of_failures_imports = $import_instance->getCountFailures();

        if($number_of_failures_imports == 0){
           return redirect()->route('agent.people.index')->with('success', $number_of_success_imports.' of records has been imported successfully!');
        }else{
          return redirect()->route('agent.people.index')->with('error', $number_of_success_imports. ' of records has been imported, and'. $number_of_failures_imports ."of records has been failed");
        }

    }
}
