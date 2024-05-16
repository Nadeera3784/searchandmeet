<?php

namespace App\Console\Commands;

use App\Models\Person;
use App\Repositories\Schedule\ScheduleRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class UpdateAvailabilities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'availability:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update people availability';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param ScheduleRepositoryInterface $scheduleRepository
     */
    public function handle(ScheduleRepositoryInterface $scheduleRepository)
    {
        $people = Person::all();
        $count = 0;
        $total = $people->count();
        foreach ($people as $person)
        {
            $timezone = $person->timezone->name;
            $purchase_requirements = $person->purchase_requirements;
            $timeslots = [];
            foreach ($purchase_requirements as $purchase_requirement)
            {
                foreach ($purchase_requirement->timeslots as $timeslot) {
                    array_push($timeslots,  $timeslot);
                }
            }

            $default_availability = ["from" => "09:00", "to" => "17:00"];

            $day_availability = [
                ["id" => 0, "name" => "monday", "availability" => [], "active" => false],
                ["id" => 1, "name" => "tuesday", "availability" => [], "active" => false],
                ["id" => 2, "name" => "wednesday", "availability" => [], "active" => false],
                ["id" => 3, "name" => "thursday", "availability" => [], "active" => false],
                ["id" => 4, "name" => "friday", "availability" => [], "active" => false],
                ["id" => 5, "name" => "saturday", "availability" => [], "active" => false],
                ["id" => 6, "name" => "sunday", "availability" => [], "active" => false],

            ];

            $custom_availability = [];

            foreach ($timeslots as $timeslot)
            {
                $date = Carbon::parse($timeslot->start, 'utc')->setTimezone($timezone)->format('Y-m-d');
                $start = Carbon::parse($timeslot->start, 'utc')->setTimezone($timezone)->format('H:i');
                $end = Carbon::parse($timeslot->end,'utc')->setTimezone($timezone)->format('H:i');

                array_push($custom_availability, [
                    'id' => Str::uuid()->toString(),
                    'date' => $date,
                    'from' => $start,
                    'to' => $end,
                ]);
            }

            $data = [
                'default_availability' => json_encode($default_availability),
                'day_availability' => json_encode($day_availability),
                'custom_availability' => json_encode($custom_availability)
            ];

            try
            {
                $scheduleRepository->update($data, $person);

                foreach ($purchase_requirements as $purchase_requirement)
                {
                    $purchase_requirement->timeslots()->delete();
                }

                $this->info("$count/$total processed");
                $count++;
            }
            catch(\Exception $exception)
            {
                $this->error($exception->getMessage());
            }
        }

        $this->info('Availability update complete');
    }
}