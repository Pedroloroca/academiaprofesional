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
            'student_id' => \App\Models\Student::factory(),
            'course_id' => \App\Models\Course::factory(),
            'enrollment_id' => null, // Optional, can be set manually
            'amount' => $this->faker->randomFloat(2, 10, 200),
            'currency' => 'EUR',
            'status' => $this->faker->randomElement(['pending', 'paid', 'failed']),
            'provider' => $this->faker->randomElement(['stripe', 'paypal']),
            'transaction_id' => $this->faker->uuid(),
            'paid_at' => $this->faker->optional()->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
