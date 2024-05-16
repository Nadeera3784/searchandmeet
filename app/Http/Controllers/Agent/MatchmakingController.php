<?php

namespace App\Http\Controllers\Agent;

use App\Enums\Agent\AgentRoles;
use App\Enums\Matchmaking\ItemTypes;
use App\Enums\Matchmaking\MatchTypes;
use App\Events\MatchCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\Agent\Matchmaking\CreateMatchRequest;
use App\Models\Country;
use App\Models\Matchmaking\Match;
use App\Models\Person;
use App\Models\PurchaseRequirement;
use App\Repositories\Matchmaking\MatchRepositoryInterface;
use Illuminate\Http\Request;

class MatchmakingController extends Controller
{
    public function index(Request $request)
    {
        $role = auth('agent')->user()->role->value;
        $matches = Match::with('person')->with('items');
        $people = Person::select(\DB::raw("CONCAT(name, ' (', email, ')') AS name"), 'id');

        if($role === AgentRoles::agent)
        {
            $matches = $matches->whereHas('person', function ($q){
                $q->where('agent_id', '=', auth('agent')->user()->id);
            });

            $people = $people->where('agent_id', auth('agent')->user()->id);
        }

        $people = $people->pluck('name', 'id');

        if($request->has('type'))
        {
            $matches = $matches->where('type', $request->get('type'));
        }

        if($request->has('person_id'))
        {
            $matches = $matches->where('person_id', $request->person_id);
        }

        $matches = $matches->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        return view('agent.matchmaking.index', get_defined_vars());
    }

    public function show(Request $request, $match)
    {
        return view('agent.matchmaking.show', get_defined_vars());
    }

    public function create(Request $request)
    {
        $countries = Country::pluck('name', 'id');
        $people = Person::select(\DB::raw("CONCAT(name, ' (', email, ')') AS name"), 'id');
        $people = $people->where('agent_id', auth('agent')->user()->id)->pluck('name', 'id');

        return view('agent.matchmaking.create', get_defined_vars());
    }

    public function store(CreateMatchRequest $request, MatchRepositoryInterface $matchRepository)
    {
        $data = $request->validated();
        $match = $matchRepository->create(array_merge(
            $data,
            [
                'initiator' => 'manual'
            ]
        ));

        foreach($data['items'] as $item)
        {
            if($match->type == MatchTypes::Supplier)
            {
                $requirementId = \Hashids::connection(PurchaseRequirement::class)->decode($item)[0] ?? null;

                $matchRepository->addItem($match, [
                    'type' => ItemTypes::PurchaseRequirement,
                    'id' => $requirementId,
                ]);
            }
            else if($match->type == MatchTypes::Buyer)
            {
                $personId =\Hashids::connection(Person::class)->decode($item)[0] ?? null;
                $matchRepository->addItem($match, [
                    'type' => ItemTypes::Person,
                    'id' => $personId,
                ]);
            }
        }

        event(new MatchCreated($match));

        return redirect()->route('agent.matchmaking.index')->with('success', 'Match created successfully!');
    }

    public function destroy(Request $request, $match, MatchRepositoryInterface $matchRepository)
    {
        $matchRepository->delete($match->id);
        return redirect()->route('agent.matchmaking.index')->with('success', 'Match deleted successfully!');
    }
}
