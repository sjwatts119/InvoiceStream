<?php

namespace Database\Seeders;

use App\Models\Arrangement;
use App\Models\Entry;
use App\Models\User;
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

        Arrangement::factory([
            'user_id' => $user->id,
        ])
        ->has(Entry::factory()->count(5))
        ->count(10)
        ->create();
    }
}
