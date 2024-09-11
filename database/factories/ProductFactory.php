<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'price' => $this->faker->randomFloat(2, 10, 500), // Random price between 10 and 500
            'stock' => $this->faker->numberBetween(0, 100),  // Random stock between 0 and 100
        ];
    }
}
