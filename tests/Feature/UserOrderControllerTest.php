<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class UserOrderControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testRegisterUserSuccessfully()
    {
        $data = [
            'username' => 'testuser',
            'email' => 'test@example.com',
        ];

        $response = $this->postJson('/api/register', $data);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message',
            'user' => ['id', 'username', 'email']
        ]);

        $this->assertDatabaseHas('users', [
            'username' => 'testuser',
            'email' => 'test@example.com',
        ]);
    }

    public function testPlaceOrderSuccessfully()
    {
        Mail::fake();
        Log::spy();

        $user = User::factory()->create();
        $product = Product::factory()->create([
            'name' => 'Test Product',
            'price' => 100,
            'stock' => 10,
        ]);

        $data = [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'shipping_type' => 'standard',
        ];

        $response = $this->postJson('/api/order', $data);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message',
            'order' => ['id', 'user_id', 'product_id', 'quantity', 'total_price']
        ]);

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'total_price' => 257.99, // Cena z kosztem wysyłki standardowej
        ]);

        Log::shouldHaveReceived('info')->with("User {$user->id} placed an order for product Test Product.");
    }

    public function testPlaceOrderWithExpressShipping()
    {
        Mail::fake();
        Log::spy();

        $user = User::factory()->create();
        $product = Product::factory()->create([
            'name' => 'Test Product',
            'price' => 100,
            'stock' => 10,
        ]);

        $data = [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'shipping_type' => 'express',
        ];

        $response = $this->postJson('/api/order', $data);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message',
            'order' => ['id', 'user_id', 'product_id', 'quantity', 'total_price']
        ]);

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'total_price' => 271.99, // Cena z kosztem wysyłki ekspresowej
        ]);

        Log::shouldHaveReceived('info')->with("User {$user->id} placed an order for product Test Product.");
    }

    public function testPlaceOrderWithOvernightShipping()
    {
        Mail::fake();
        Log::spy();

        $user = User::factory()->create();
        $product = Product::factory()->create([
            'name' => 'Test Product',
            'price' => 100,
            'stock' => 10,
        ]);

        $data = [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'shipping_type' => 'overnight',
        ];

        $response = $this->postJson('/api/order', $data);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message',
            'order' => ['id', 'user_id', 'product_id', 'quantity', 'total_price']
        ]);

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'total_price' => 291.99, // Cena z kosztem wysyłki na następny dzień
        ]);

        Log::shouldHaveReceived('info')->with("User {$user->id} placed an order for product Test Product.");
    }

    public function testApplyDiscountForLargeOrder()
    {
        Mail::fake();
        Log::spy();

        $user = User::factory()->create();
        $product = Product::factory()->create([
            'name' => 'Test Product',
            'price' => 100,
            'stock' => 100,
        ]);

        $data = [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 20,
            'shipping_type' => 'standard',
        ];

        $response = $this->postJson('/api/order', $data);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message',
            'order' => ['id', 'user_id', 'product_id', 'quantity', 'total_price']
        ]);

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 20,
            'total_price' => 2192.391, // Cena po zniżce
        ]);

        Log::shouldHaveReceived('info')->with("User {$user->id} placed an order for product Test Product.");
    }

    public function testCreateProductSuccessfully()
    {
        $response = $this->postJson('/api/products/create-or-update', [
            'name' => 'New Product',
            'price' => 149.99,
            'stock' => 20,
            'tags' => ['electronics'],
            'description' => 'A new electronic product',
            'category' => 'Electronics',
            'manufacturer' => 'TechCorp',
            'sku' => 'XYZ123',
            'weight' => 1.5,
            'dimensions' => '10x5x2',
            'color' => 'Black',
            'size' => 'Medium',
            'material' => 'Plastic',
            'warranty' => '2 years',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message',
            'product' => ['id', 'name', 'price', 'stock', 'tags', 'description', 'category', 'manufacturer', 'sku', 'weight', 'dimensions', 'color', 'size', 'material', 'warranty']
        ]);

        $this->assertDatabaseHas('products', [
            'name' => 'New Product',
            'price' => 149.99,
            'stock' => 20,
        ]);
    }

    public function testUpdateProductSuccessfully()
    {
        $product = Product::factory()->create();

        $response = $this->postJson('/api/products/create-or-update', [
            'id' => $product->id,
            'name' => 'Updated Product',
            'price' => 199.99,
            'stock' => 30,
            'tags' => ['gadgets'],
            'description' => 'Updated description',
            'category' => 'Gadgets',
            'manufacturer' => 'NewCorp',
            'sku' => 'ABC456',
            'weight' => 2.0,
            'dimensions' => '15x7x3',
            'color' => 'White',
            'size' => 'Large',
            'material' => 'Metal',
            'warranty' => '1 year',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message',
            'product' => ['id', 'name', 'price', 'stock', 'tags', 'description', 'category', 'manufacturer', 'sku', 'weight', 'dimensions', 'color', 'size', 'material', 'warranty']
        ]);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated Product',
            'price' => 199.99,
            'stock' => 30,
        ]);
    }
}
