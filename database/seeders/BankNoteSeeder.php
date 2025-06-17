<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Currency;
use App\Models\BankNote;

class BankNoteSeeder extends Seeder
{
    public function run(): void
    {
        $currencies = Currency::all();

        foreach ($currencies as $currency) {
            foreach ([1, 5, 10, 20, 50, 100] as $denomination) {
                BankNote::create([
                    'currency_id' => $currency->id,
                    'denomination' => $denomination,
                    'count' => rand(10, 100),
                ]);
            }
        }
    }
}
