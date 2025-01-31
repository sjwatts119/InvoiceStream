<?php

namespace Database\Factories;

use App\Models\Arrangement;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArrangementFactory extends Factory
{
    protected $model = Arrangement::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'currency' => 'GBP',
            'rate' => $this->faker->randomFloat(2, 0, 100),
        ];
    }
}
