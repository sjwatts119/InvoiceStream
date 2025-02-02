<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Arrangement;
use App\Models\Entry;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
            'permitted' => true,
        ]);

        User::factory()->create([
            'name' => 'Other User',
            'email' => 'other@example.com',
            'permitted' => false,
        ]);

        $user->address()->update(
            Address::factory([
                'addressable_id' => $user->id,
                'addressable_type' => User::class,
            ])->make()->toArray());

        $arrangements = Arrangement::factory([
            'user_id' => $user->id,
        ])
        ->has(Entry::factory()->count(25))
        ->count(25)
        ->create();

        $arrangements->each(function (Arrangement $arrangement): void {
            $arrangement->address()->updateOrCreate(
                [],
                Address::factory([
                    'addressable_id' => $arrangement->id,
                    'addressable_type' => Arrangement::class,
                ])->make()->toArray());
        });

        $arrangements->each(function (Arrangement $arrangement): void {
            DB::transaction(function () use ($arrangement): void {
                $invoice = Invoice::factory([
                    'user_id' => $arrangement->user_id,
                ])->create();

                $entries = $arrangement->entries()->inRandomOrder()->take(rand(1, 10));

                $entries->update([
                    'invoice_id' => $invoice->id,
                ]);
            });
        });
    }
}
