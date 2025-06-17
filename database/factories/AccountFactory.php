<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Currency;

class AccountFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'currency_id' => Currency::inRandomOrder()->first()?->id ?? Currency::factory(),
            'amount' => $this->faker->numberBetween(100, 10000),
        ];
    }
}
