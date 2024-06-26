<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'test user',
            'email' => 'test@example.com',
            'password' => bcrypt('111'),
            'role' => 'user',
        ]);

        User::factory()->create([
            'name' => 'admin user',
            'email' => 'test@admin.com',
            'password' => bcrypt('111'),
            'role' => 'admin',
        ]);
    }
}
