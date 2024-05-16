<?php

namespace App\Jobs;

use App\Enums\Matchmaking\ItemTypes;
use App\Enums\Matchmaking\MatchTypes;
use App\Events\MatchCreated;
use App\Models\Person;
use App\Repositories\Matchmaking\MatchRepositoryInterface;
use App\Services\Matchmaking\MatchmakingServiceInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class NotifyDailySuggestedSuppliers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $timeout = 600;
    private $matchingService;
    private $matchRepository;

    public function __construct()
    {
        $this->matchingService = app()->make(MatchmakingServiceInterface::class);
        $this->matchRepository = app()->make(MatchRepositoryInterface::class);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info('Matchmaking suppliers -> products');
        $results = collect([]);
        $attempts = 0;

        //todo: Unique matches only

        while($results->count() < 5 && $attempts < 500)
        {
            $people = Person::all()->random(100);
            foreach($people as $person)
            {
                if($person->generalizedType() === 'buyer')
                {
                    if(isset($person->business)) {
                        try {
                            $matches = $this->matchingService->getMatchesForBuyer($person);
                            if (count($matches) > 0) {
                                $results->push([
                                    'person' => $person,
                                    'matches' => $matches
                                ]);
                            }
                        } catch (\Exception $exception) {

                        }
                    }
                }
            }

            $attempts++;
        }

        if($results->count() > 0)
        {
            foreach ($results as $result)
            {
                $match = $this->matchRepository->create([
                    'person_id' => $result['person']->id,
                    'type' => MatchTypes::Buyer,
                    'initiator' => 'system'
                ]);

                foreach ($result['matches'] as $item) {
                    $this->matchRepository->addItem($match, [
                        'id' => $item->id,
                        'type' => ItemTypes::Person,
                    ]);
                }

                event(new MatchCreated($match));
            }
        }
        else
        {
            Log::info('Matchmaking unsuccessful for buyers');
        }
    }
}
