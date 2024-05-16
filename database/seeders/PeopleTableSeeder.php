<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\PurchaseRequirement;
use App\Models\Timeslot;
use Illuminate\Database\Seeder;

class PeopleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Person::factory()->count(5)
            ->has(Business::factory()->count(1))
            ->has(
                PurchaseRequirement::factory()->count(5)
                    ->has(Timeslot::factory()->count(3), 'timeslots')
                , 'purchase_requirements')
            ->create();
    }
}
