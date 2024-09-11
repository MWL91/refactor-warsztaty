<?php

namespace Database\Factories;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriptionFactory extends Factory
{
    protected $model = Subscription::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // Powiązanie z faktorią User
            'price' => $this->faker->randomFloat(2, 10, 100), // Cena z przedziału od 10 do 100
        ];
    }
}
