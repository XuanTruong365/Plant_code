<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Category;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->faker->unique()->words(3, true);
        return [
            'category_id' => Category::inRandomOrder()->value('id'),
            'name' => $name,
            'slug' => Str::slug($name) . '-' . Str::random(4),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->numberBetween(100000, 2000000),
            'stock' => $this->faker->numberBetween(0, 100),
            'status' => 1,
        ];
    }
}
