<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Currency;

class BankNoteFactory extends Factory
{
    public function definition(): array
    {
        return [
            'currency_id' => Currency::inRandomOrder()->first()?->id ?? Currency::factory(),
            'denomination' => $this->faker->randomElement([1, 5, 10, 20, 50, 100]),
            'count' => $this->faker->numberBetween(5, 100),
        ];
    }
}
