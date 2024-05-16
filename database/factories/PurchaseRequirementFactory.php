<?php

namespace Database\Factories;

use App\Enums\PurchaseRequirementStatus;
use App\Models\Person;
use App\Models\PurchaseRequirement;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PurchaseRequirementFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PurchaseRequirement::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product' => $this->faker->word,
            'description' => $this->faker->words(3, true),
            'quantity' => rand(1, 20),
            'price' => rand(1, 10000),
            'url' => $this->faker->url(),
            'pre_meeting_sample' => $this->faker->words(3, true),
            'trade_term' => rand(1, 5),
            'payment_term' => rand(1, 5),
            'looking_to_meet' => rand(1, 5),
            'looking_from' => rand(1, 5),
            'certification_requirement' => $this->faker->words(3, true),
            //'hs_code' => $this->faker->word,
            'metric_id' => rand(1,50),
            'category_id' =>  rand(1,50),
            'target_purchase_date' => Carbon::now()->addDays(rand(5,20)),
            'purchase_frequency' => rand(1,4),
            'purchase_policy' => rand(1,7),
            'warranties_requirement' => $this->faker->words(3, true),
            'safety_standard' => $this->faker->words(3, true),
            'status' => PurchaseRequirementStatus::Published
        ];
    }
}
