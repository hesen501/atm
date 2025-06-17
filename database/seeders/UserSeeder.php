<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create 10 normal users
        User::factory()->count(10)->create();

        // Optionally create 1 admin user
        User::factory()->create([
            'name' => 'admin',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
            'daily_limit' => 10000,
        ]);
    }
}
