<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Account;
use App\Models\User;
use App\Models\Currency;

class AccountSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure we have users and currencies before creating accounts
        if (User::count() === 0) {
            \App\Models\User::factory()->count(5)->create();
        }

        if (Currency::count() === 0) {
            \App\Models\Currency::factory()->count(2)->create(); // e.g. AZN, USD
        }

        // Create accounts (unique user + currency pairs)
        $users = User::all();
        $currencies = Currency::all();

        foreach ($users as $user) {
            foreach ($currencies as $currency) {
                Account::factory()->create([
                    'user_id' => $user->id,
                    'currency_id' => $currency->id,
                ]);
            }
        }
    }
}
