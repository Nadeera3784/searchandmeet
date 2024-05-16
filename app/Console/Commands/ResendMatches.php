<?php

namespace App\Console\Commands;

use App\Events\MatchCreated;
use App\Models\Matchmaking\Match;
use Illuminate\Console\Command;

class ResendMatches extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'matchmaking:resend';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Resend unsent match notifications';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
       $matches = Match::where('notification_status', 0)->get();
       foreach($matches as $match)
       {
            event(new MatchCreated($match));
       }
    }
}