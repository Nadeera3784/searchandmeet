<?php

namespace App\Http\Controllers;

use App\Enums\Business\AnnualRevenueBracket;
use App\Enums\Business\BusinessType;
use App\Enums\Business\CompanyType;
use App\Enums\Business\EmployeeCountBracket;
use App\Events\PersonStatusCheck;
use App\Http\Requests\Web\Person\UpdatePaymentMethod;
use App\Models\Business;
use App\Models\Category;
use App\Models\Country;
use App\Models\NaicCode;
use App\Models\SaicCode;
use App\Models\Metric;
use Illuminate\Http\Request;

class PeopleController extends Controller
{
    public function index()
    {
        return false;
    }

    public function on_boarding(Request $request)
    {
        $person = auth('person')->user();
        $countries = Country::pluck('name', 'id');
        $categories = Category::pluck('name', 'id');
        $naic_codes =  NaicCode::select(\DB::raw("CONCAT(code, ' (', name, ')') AS name"), 'id')->pluck('name', 'id');
        $saic_codes =  SaicCode::select(\DB::raw("CONCAT(code, ' (', name, ')') AS name"), 'id')->pluck('name', 'id');
        $metrics = Metric::pluck('name', 'id');
        $business_types = BusinessType::asSelectArray();
        $company_types = CompanyType::asSelectArray();
        $employeeCountBrackets = EmployeeCountBracket::asSelectArray();
        $annualRevenueBrackets = AnnualRevenueBracket::asSelectArray();

        if($person->paymentMethods()->count() === 0 && !$request->has('skip_card'))
        {
            return view('profile.onboarding.card', get_defined_vars());
        }
        else if(!Business::where('person_id', $person->id)->exists())
        {
            return view('profile.onboarding.business', get_defined_vars());
        }
        else
        {
            PersonStatusCheck::dispatch($person);
            if($redirect = $request->session()->get('redirect_after_onboarding'))
            {
                $request->session()->forget('redirect_after_onboarding');
                return redirect()->to($redirect);
            }
            return redirect()->route('person.dashboard');
        }
    }

    public function update_payment_method(UpdatePaymentMethod $request)
    {
        try
        {
            $payment_method = $request->validated()['payment_method'];
            $person = auth('person')->user();
            $person->updateDefaultPaymentMethod($payment_method['id']);

            if($request->expectsJson())
            {
                return response()->json(['message' => 'success'], 200);
            }
        }
        catch (\Exception $e)
        {
            return response()->json(['message' => 'error', 'error' => $e->getMessage()], 400);
        }

    }
}
