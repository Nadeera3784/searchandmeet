<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Timeslot;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class TimeslotFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Timeslot::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $start = Carbon::now()->addDays(rand(1,10));
        $end = $start->addHour(rand(1,2));

        return [
           'start' => $start,
           'end' => $end,
        ];
    }
}
