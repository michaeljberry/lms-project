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
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->call(RolePermissionSeeder::class);

        $user->profile()->create([
            'first_name' => 'Test',
            'last_name' => 'User',
            'learning_objectives' => 'Explore the platform',
            'skills' => ['testing'],
            'interests' => ['laravel'],
            'timezone' => 'UTC',
            'location' => 'Internet',
        ]);

        \App\Models\Course::firstOrCreate(['title' => 'Sample Course']);
    }
}
