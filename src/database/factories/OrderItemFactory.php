<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Order;
use App\Models\Product;

class OrderItemFactory extends Factory
{
    public function definition(): array
    {
        $price    = $this->faker->numberBetween(100000, 500000);
        $quantity = $this->faker->numberBetween(1, 5);

        return [
            'order_id'   => Order::inRandomOrder()->value('id'),
            'product_id' => Product::inRandomOrder()->value('id'),
            'quantity'   => $quantity,
            'price'      => $price,
            'subtotal'   => $price * $quantity, // ✅ tính tự động
        ];
    }
}

