<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class SearchLogFactory extends Factory
{
    public function definition(): array
    {
        return [
            'keyword' => $this->faker->word(),
            'user_id' => User::inRandomOrder()->value('id'),
            'result_count' => $this->faker->numberBetween(0, 50),
        ];
    }
}
