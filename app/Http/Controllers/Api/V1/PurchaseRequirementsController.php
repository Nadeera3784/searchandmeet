<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\PurchaseRequirement\CreatePurchaseRequirementRequest;
use App\Http\Resources\PurchaseRequirementResource;
use App\Models\Category;
use App\Models\Person;
use App\Models\PurchaseRequirement;
use App\Repositories\Person\PersonRepositoryInterface;
use App\Repositories\PurchaseRequirement\PurchaseRequirementRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Vinkla\Hashids\Facades\Hashids;

class PurchaseRequirementsController extends ApiController
{
    private $purchaseRequirementRepository;
    private $personRepository;
    public function __construct(PurchaseRequirementRepositoryInterface $purchaseRequirementRepository, PersonRepositoryInterface $personRepository)
    {
        $this->purchaseRequirementRepository = $purchaseRequirementRepository;
        $this->personRepository = $personRepository;
    }

    public function show(Request $request, $purchase_requirement)
    {
        $purchase_requirement = PurchaseRequirement::with('timeslots')->find($purchase_requirement->id);
        return response()->json(['purchase_requirement' => $purchase_requirement] ,200);
    }

    public function search(Request $request)
    {
        $requirements = PurchaseRequirement::with('person');
        $agent_id = null;

        if($request->has('limit_to_agent') && $request->get('limit_to_agent') == 1)
        {
            if(auth('agent')->check())
            {
                $agent_id = auth('agent')->user()->id;
                $requirements = $requirements->whereHas('person', function ($q) use ($agent_id){
                    $q->where('agent_id', '=', $agent_id);
                });
            }
        }

        if($request->has('country_id'))
        {
            $country_id = $request->get('country_id');
            $requirements = $requirements->whereHas('person.business', function ($q) use ($country_id){
                $q->where('country_id', '=', $country_id);
            });
        }

        if($request->has('category_id'))
        {
            $category_id = $request->get('category_id');
            $categories = Category::childCategories($category_id);
            array_push($categories, $category_id);
            $requirements = $requirements->whereIn('category_id', $categories);
        }

        if($request->has('q')){
            $search = $request->q;
            $requirements = $requirements->where(function($q) use($search) {
                $q->where('product', 'LIKE', "%$search%");
                $q->orWhereHas('person', function($q) use($search) {
                    $q->where('email', 'LIKE', "%$search%");
                });
            });
        }

        $requirements = $requirements->limit(30)->get();

        return response()->json(PurchaseRequirementResource::collection($requirements), 200);
    }

    public function create(CreatePurchaseRequirementRequest $request)
    {
        if($request->has('person_id'))
        {

            $id = Hashids::connection(\App\Models\Person::class)->decode($request->person_id)[0] ?? null;
            $person = $this->personRepository->getById($id);

            DB::beginTransaction();
            try
            {
                $purchase_requirement = $this->purchaseRequirementRepository->create($request->validated(), $person);
                DB::commit();

                return $this->sendResponse('success', ['purchase_requirement' => new PurchaseRequirementResource($purchase_requirement)], 200);
            }
            catch (\Exception $exception)
            {
                DB::rollBack();
                return $this->sendResponse('failed', ['error' => $exception->getMessage()], 400);
            }
        }
        else
        {
            return $this->sendResponse('failed', ['error' => 'A person is required to create purchase requirement'], 400);
        }
    }
}
