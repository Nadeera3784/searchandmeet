<?php

namespace Database\Factories;

use App\Models\Person;
use App\Models\Business;
use App\Enums\Business\BusinessType;
use Illuminate\Database\Eloquent\Factories\Factory;

class BusinessFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Business::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(){
        return [
            'country_id'        => rand(1, 246),
            'type_id'           => rand(1, 6),
            'company_type_id'           => rand(1, 10),
            'name'             => $this->faker->company(),
            'current_importer' => 'no',
            'phone'            => $this->faker->phoneNumber(),
            'website'          => $this->faker->domainName(),
            'linkedin'         => '',
            'facebook'         => '',
            'address'          => $this->faker->secondaryAddress(),
            'city'             => $this->faker->city(),
            'state'            => $this->faker->state(),
            'founded_year' => $this->faker->year,
            'HQ' => $this->faker->words(3, true),
            'employee_count' => $this->faker->numberBetween(1, 50),
            'annual_revenue' => $this->faker->numberBetween(1, 100000),
            //'sic_code' => $this->faker->numberBetween(1000, 5000),
            //'naics_code' => $this->faker->numberBetween(1000, 5000),
        ];
    }
}
