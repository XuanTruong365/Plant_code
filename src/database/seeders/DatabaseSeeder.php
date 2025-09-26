<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\SearchLog;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // 1. Users
        User::factory(20)->create();

        // 2. Categories
        Category::factory(8)->create();

        // 3. Products
        Product::factory(30)->create();

        // 4. Tags & pivot
        $tags = Tag::factory(10)->create();
        Product::all()->each(function($product) use ($tags) {
            $product->tags()->attach(
                $tags->random(rand(1,3))->pluck('id')->toArray()
            );
        });

        // 5. Orders & Items
        Order::factory(15)->create();
        OrderItem::factory(40)->create();

        // 6. Search Logs
        SearchLog::factory(30)->create();

        // 7. Notifications
        Notification::factory(20)->create();
    }
}
