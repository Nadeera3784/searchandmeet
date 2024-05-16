<?php


namespace App\Services\Matchmaking;

use App\Models\Person;

interface MatchmakingServiceInterface
{
    public function getMatchesForSupplier(Person $person);

    public function getMatchesForBuyer(Person $person);
}
