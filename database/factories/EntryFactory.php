<?php

namespace Database\Factories;

use App\Models\Entry;
use Illuminate\Database\Eloquent\Factories\Factory;

class EntryFactory extends Factory
{
    protected $model = Entry::class;

    public function definition(): array
    {
        return [
            'date' => $this->faker->dateTimeBetween('-1 year'),
            'hours' => $this->faker->randomFloat(2, 0, 16),
            'rate' => $this->faker->randomFloat(2, 0, 100),
        ];
    }
}
