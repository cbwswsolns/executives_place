<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'company_name' => $this->faker->sentence(3),
            'job_title' => $this->faker->sentence(2),
            'phone' => $this->faker->randomElement([
                            // Formats to satisfy
                            '07654 123456',
                            '07654123456',
                            '+44 (0)1234 567890',
                            '+44(0)1234 567890',
                            '+44(0) 1234 567890',
                            '01234 567890',
                            '01234567890'
                        ]),
            'email' => $this->faker->unique()->safeEmail,
            'hourly_rate' => $this->faker->randomFloat(2, 0, 100),
            'currency' => $this->faker->randomElement(
                config('exchangerate.allowed_currencies')
            )
        ];
    }
}
