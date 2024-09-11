<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(), // Stworzy nowego użytkownika lub wybierze istniejącego
            'product_id' => Product::factory(), // Stworzy nowy produkt lub wybierze istniejący
            'quantity' => $this->faker->numberBetween(1, 5), // Random quantity between 1 and 5
            'total_price' => $this->faker->randomFloat(2, 20, 1000), // Random total price between 20 and 1000
        ];
    }
}
