<?php

namespace App\Http\Controllers;

use App\Enums\Business\AnnualRevenueBracket;
use App\Enums\Business\BusinessType;
use App\Enums\Business\CompanyType;
use App\Enums\Business\EmployeeCountBracket;
use App\Enums\Person\AccountStatus;
use App\Events\PersonStatusCheck;
use App\Services\Events\EventTrackingService;
use App\Http\Requests\Web\Business\UpdateBusinessRequest;
use App\Models\Category;
use App\Models\Country;
use App\Models\Metric;
use App\Models\NaicCode;
use App\Models\SaicCode;

class BusinessController extends Controller
{
    public function index()
    {
        return false;
    }

    public function show(EventTrackingService $userEventsService){
        $countries = Country::pluck('name', 'id');
        $categories = Category::pluck('name', 'id');
        $metrics = Metric::pluck('name', 'id');
        $naic_codes =  NaicCode::select(\DB::raw("CONCAT(code, ' (', name, ')') AS name"), 'id')->pluck('name', 'id');
        $saic_codes =  SaicCode::select(\DB::raw("CONCAT(code, ' (', name, ')') AS name"), 'id')->pluck('name', 'id');
        $business_types = BusinessType::asSelectArray();
        $company_types = CompanyType::asSelectArray();
        $employeeCountBrackets = EmployeeCountBracket::asSelectArray();
        $annualRevenueBrackets = AnnualRevenueBracket::asSelectArray();
        $business = auth('person')->user()->business;

        if($business && $business->type()){

            $userEventsService->identify(["businessType" => $business->type()->description]);
        }
        
        return view('business.show', get_defined_vars());
    }

    public function update(UpdateBusinessRequest $request)
    {
      $business = auth('person')->user()->business;

      if(!$business)
      {
          auth('person')->user()->business()->create($request->validated());
      }
      else
      {
          $business->update($request->validated());
      }

      if(auth('person')->user()->status === AccountStatus::OnBoarding)
      {
          PersonStatusCheck::dispatch(auth('person')->user());
          if($redirect = $request->session()->get('redirect_after_onboarding'))
          {
              $request->session()->forget('redirect_after_onboarding');
              return redirect()->to($redirect);
          }
          return redirect()->route('person.dashboard');
      }

      return redirect()->route('person.business.show')->with('success', 'Business updated successfully!');
    }
}
