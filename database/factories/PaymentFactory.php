<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'method' => $this->faker->randomElement(['cash', 'transfer']),
            'amount' => $this->faker->randomFloat(2, 50, 500),
            'payment_date' => $this->faker->date(),
            'description' => $this->faker->sentence,
            'registration_id' => \App\Models\Registration::factory(),
        ];
    }
}
