<?php

namespace Database\Factories;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contact::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'   => 1,
            'first_name'=> $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email'     => $this->faker->unique()->safeEmail(),
            'msistn'    => $this->faker->phoneNumber(),
            'contact_title_id' => rand(1, 2),
        ];
    }
}
