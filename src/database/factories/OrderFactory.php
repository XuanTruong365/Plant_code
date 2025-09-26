<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class OrderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id'       => User::inRandomOrder()->value('id'),
            'order_number'  => strtoupper($this->faker->bothify('ORD-####')),
            'total'         => $this->faker->numberBetween(200000, 5000000),
            'shipping_fee'  => $this->faker->numberBetween(0, 50000), // hoặc 0 nếu free ship
            'payment_method'=> $this->faker->randomElement(['cod','bank','paypal']),
            'status'        => $this->faker->randomElement(['pending','paid','shipped','completed']),
        ];
    }
}
