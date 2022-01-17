<?php

namespace Database\Factories;

use App\Models\LoanApplication;
use Illuminate\Database\Eloquent\Factories\Factory;

class LoanTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'interest' => $this->faker->randomDigit()
        ];
    }
}
