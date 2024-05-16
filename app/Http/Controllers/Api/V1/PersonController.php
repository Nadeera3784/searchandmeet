<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\Person\AccountStatus;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\Person\CreatePersonRequest;
use App\Http\Resources\PersonResource;
use App\Models\Person;
use App\Models\User;
use App\Repositories\Business\BusinessRepositoryInterface;
use App\Repositories\Person\PersonRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Exports\PersonExport;

class PersonController extends ApiController
{
    private $businessRepository;
    private $personRepository;
    public function __construct(PersonRepositoryInterface $personRepository, BusinessRepositoryInterface $businessRepository)
    {
        $this->personRepository = $personRepository;
        $this->businessRepository = $businessRepository;
    }

    public function get(Request $request, $person)
    {
        return $this->sendResponse('success', new PersonResource($person), 200);
    }

    public function index(Request $request)
    {
        $people = $this->personRepository->getAll($request->all());
        return $this->sendResponse('success', ['results' => PersonResource::collection($people)], 200);
    }

    public function create(CreatePersonRequest $request)
    {
        $agent_id = null;
        $status = AccountStatus::OnBoarding;
        if(isset($request->validated()['agent_id']))
        {
            $agent_id = \Hashids::connection(User::class)->decode($request->validated()['agent_id'])[0] ?? null;
            $status = AccountStatus::Verified;
        }

        DB::beginTransaction();
        try
        {
            $person = $this->personRepository->create(
               array_merge(
                   $request->validated(),
                    [
                        'email_verified_at' => Carbon::now(),
                        'source' => 'api',
                        'status' => $status
                    ]
               ), $agent_id, false);

            $this->businessRepository->create($request->validated(), $person);

            DB::commit();
            return $this->sendResponse('success', ['results' => new PersonResource($person)], 200);
        }
        catch (\Exception $exception)
        {
            DB::rollBack();
            return $this->sendResponse('failed', ['error' => $exception->getMessage()], 400);
        }
    }

    public function export(Request $request){
        return (new PersonExport($request->name, $request->email, $request->looking_for))->download('persons.xlsx');
    }

    public function search(Request $request)
    {
        $people = Person::with('business');
        if($request->has('q')){
            $search = $request->q;
            $people = $people->where(function($q) use ($search){
                $q->where('name', 'LIKE', "%$search%");
                $q->orWhere('email', 'LIKE', "%$search%");
                $q->orWhereHas('business', function($q) use ($search) {
                    $q->where('name', 'LIKE', "%$search%");
                });
            });
        }

        if($request->has('limit_to_agent') && $request->get('limit_to_agent') == 1)
        {
            if(auth('agent')->check())
            {
                $agent_id = auth('agent')->user()->id;
                $people = $people->where('agent_id', $agent_id);
            }
        }

        if($request->has('country_id'))
        {
            if(auth('agent')->check())
            {
                $agent_id = auth('agent')->user()->id;
                $people = $people->where('agent_id', $agent_id);
            }
        }

        $people = $people->limit(30)->get();

        if($request->has('type'))
        {
            $type = $request->get('type');
            $people = $people->filter(function($person) use ($type) {
                return $person->generalizedType() === $type;
            });
        }

        return response()->json(PersonResource::collection($people), 200);
    }
}
