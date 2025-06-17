<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CurrencyFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->country(),
            'code' => $this->faker->unique()->currencyCode(),
        ];
    }
}
