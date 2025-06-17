<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Currency;

class CurrencySeeder extends Seeder
{
    public function run(): void
    {
        Currency::factory()->create([
            'title' => 'Azərbaycan Manatı',
            'code' => 'AZN',
        ]);

        Currency::factory()->create([
            'title' => 'Amerikan Dolları',
            'code' => 'USD',
        ]);
    }
}
