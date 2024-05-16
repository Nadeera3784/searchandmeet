<?php

namespace App\Http\Controllers;

use App\Enums\Payment\PaymentTerms;
use App\Enums\Payment\TradeTerms;
use App\Enums\ProspectLocation;
use App\Enums\ProspectType;
use App\Enums\PurchaseFrequency;
use App\Enums\PurchasePolicy;
use App\Http\Requests\Web\PurchaseRequirement\UpdatePurchaseRequirement;
use App\Http\Requests\Web\PurchaseRequirement\CreatePurchaseRequirementRequest;
use App\Repositories\PurchaseRequirement\PurchaseRequirementRepositoryInterface;
use App\Services\Events\EventTrackingService;
use Faker\Factory;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\Category;
use App\Models\PurchaseRequirement;
use App\Models\Metric;
use App\Models\HsCode;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class PurchaseRequirementController extends Controller
{
    private $purchaseRequirementRepository;
    public function __construct(PurchaseRequirementRepositoryInterface $purchaseRequirementRepository)
    {
        $this->purchaseRequirementRepository = $purchaseRequirementRepository;
    }

    public function index()
    {
        $purchase_requirements = PurchaseRequirement::where('person_id',auth('person')->user()->id)->paginate(10);
        return view('purchase_req.index',get_defined_vars());
    }

    public function show($purchase_requirement, EventTrackingService $userEventsService){
        $countries = Country::pluck('name', 'id');
        $prospectTypes = ProspectType::asSelectArray();
        $phoneCodes = Country::pluck('phonecode', 'id')->unique();
        $faker = Factory::create();

        $userEventsService->track('Purchasing Requirement', [
            "product" => $purchase_requirement->product,
            "category" => $purchase_requirement->category->name,
            "sessionId" => Session::getId()
        ]);

        return view('purchase_req.show', get_defined_vars());
    }

    public function show_slug($slug, EventTrackingService $userEventsService){

        $purchase_requirement = PurchaseRequirement::where('slug', $slug)->first();

        if(!$purchase_requirement){
           abort(404);
        }

        $countries = Country::pluck('name', 'id');
        $prospectTypes = ProspectType::asSelectArray();
        $phoneCodes = Country::pluck('phonecode', 'id')->unique();
        $faker = Factory::create();

        $userEventsService->track('Purchasing Requirement', [
            "product" => $purchase_requirement->product,
            "category" => $purchase_requirement->category->name,
            "sessionId" => Session::getId()
        ]);

        return view('purchase_req.show', get_defined_vars());
    }

    public function create(Request $request)
    {
        $countries = Country::pluck('name', 'id');
        $metrics = Metric::pluck('name', 'id'); 
        $hs_codes = HsCode::select(\DB::raw("CONCAT(code, ' (', name, ')') AS name"), 'id')->pluck('name', 'id');
        $purchasePolicies = PurchasePolicy::asSelectArray();
        $purchaseFrequencies = PurchaseFrequency::asSelectArray();
        $prospectLocations = ProspectLocation::asSelectArray();
        $prospectTypes = ProspectType::asSelectArray();
        $paymentTerms = PaymentTerms::asSelectArray();
        $tradeTerms = TradeTerms::asSelectArray();

        return view('purchase_req.create', get_defined_vars());
    }

    public function store(CreatePurchaseRequirementRequest $request){

        $data = $request->validated();

        $purchase_req = $this->purchaseRequirementRepository->create($data, auth('person')->user());
        return redirect()->route('person.purchase_requirements.index')->with('success', 'Purchase requirement added successfully!');
    }

    public function edit($purchase_requirement)
    {
        $countries = Country::pluck('name', 'id');
        $metrics = Metric::pluck('name', 'id');
        $hs_codes = HsCode::select(\DB::raw("CONCAT(code, ' (', name, ')') AS name"), 'id')->pluck('name', 'id');
        $purchasePolicies = PurchasePolicy::asSelectArray();
        $purchaseFrequencies = PurchaseFrequency::asSelectArray();
        $prospectLocations = ProspectLocation::asSelectArray();
        $prospectTypes = ProspectType::asSelectArray();
        $paymentTerms = PaymentTerms::asSelectArray();
        $tradeTerms = TradeTerms::asSelectArray();

        return view('purchase_req.edit', get_defined_vars());
    }

    public function update(UpdatePurchaseRequirement $request, $purchase_requirement){

        $data = $request->validated();

        $this->purchaseRequirementRepository->update($data, $purchase_requirement->id);
        return redirect()->route('person.purchase_requirements.index')->with('success', 'Purchase Requirement updated successfully!');
    }


    public function delete($purchase_requirement)
    {
        $this->purchaseRequirementRepository->delete($purchase_requirement->id);
        return redirect()->route('person.purchase_requirements.index')->with('success','Purchase requirement deleted successfully!');
    }
}
