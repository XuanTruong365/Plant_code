<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class NotificationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->value('id'),
            'title'   => $this->faker->sentence(5),
            'message' => $this->faker->sentence(10),
            'type'    => $this->faker->randomElement(['system','order','promo']),
            'is_read' => false,
            'read_at' => null,
        ];
    }
}
