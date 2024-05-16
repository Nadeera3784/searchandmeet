<?php

namespace App\Http\Controllers\Agent;

use App\Enums\Agent\AgentRoles;
use App\Enums\Package\PackageStatus;
use App\Enums\Person\AccountStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Agent\Package\CreatePackageRequest;
use App\Models\Country;
use App\Models\Package;
use App\Models\Person;
use App\Repositories\Package\PackageRepositoryInterface;
use App\Services\Cart\CostCalculatorService;
use App\Services\Payment\PaymentService;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;

class PackageController extends Controller {

    private $packageRepository;

    public function __construct(PackageRepositoryInterface $packageRepository){
        $this->packageRepository = $packageRepository;
    }

    public function index()
    {
        $role = auth('agent')->user()->role->value;
        if($role === AgentRoles::agent || $role === AgentRoles::translator)
        {
            $packages = $this->packageRepository->getByAgent(auth('agent')->user());
        }
        else
        {
            $packages = Package::with('person')->paginate(15);
        }

        return view('agent.packages.index', get_defined_vars());
    }

    public function show(Request $request, $package)
    {

        return view('agent.packages.show', get_defined_vars());
    }

    public function create(Request $request)
    {
        $people = Person::select(\DB::raw("CONCAT(name, ' (', email, ')') AS name"), 'id')->where('status', AccountStatus::Verified);
        $role = auth('agent')->user()->role->value;
        if($role === AgentRoles::agent || $role === AgentRoles::translator)
        {
            $people = $people->where('agent_id', auth('agent')->user()->id);
        }

        $people = $people->pluck('name', 'id');
        $countries = Country::pluck('name', 'id');

        return view('agent.packages.create', get_defined_vars());
    }

    public function store(CreatePackageRequest $request, PaymentService $paymentService, CostCalculatorService $costCalculatorService){

        $id = Hashids::connection(\App\Models\Person::class)->decode($request->person_id)[0] ?? null;
        $data = $request->validated();
        $data['person_id'] = $id;
        $package = $this->packageRepository->create($data);

        $product = $paymentService->createProduct($package);
        $total = $costCalculatorService->calculatePackageCost($package);
        $price = $paymentService->createPrice($product, $total);

        $invoice = $paymentService->createInvoice($package->person, $price);

        $finalizedInvoice = $paymentService->finalizeInvoice($invoice);

        $this->packageRepository->update([
            'payment_link' => $finalizedInvoice['hosted_invoice_url'],
            'invoice_id' => $invoice->id,
        ], $package->id);

        return redirect()->route('agent.packages.index')->with('success', 'Package created successfully!');
    }

    public function destroy($package){

        if($package->status !== PackageStatus::Active)
        {
            $this->packageRepository->delete($package->id);
            return redirect()->route('agent.packages.index')->with('success', 'Package deleted successfully!');
        }
        else
        {
            return redirect()->route('agent.packages.index')->with('error', 'Unable to delete active package');
        }
    }
}
