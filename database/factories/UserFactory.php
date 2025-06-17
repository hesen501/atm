<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->userName,
            'password' => Hash::make('password'), // default password
            'daily_limit' => $this->faker->numberBetween(100, 1000),
            'role' => 'user',
        ];
    }
}
