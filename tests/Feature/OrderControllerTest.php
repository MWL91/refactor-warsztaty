<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateOrderSuccessfully()
    {
        Log::spy();

        $data = [
            'user_id' => User::factory()->create()->id,
            'product_id' => Product::factory()->create()->id,
            'quantity' => 2,
        ];

        $response = $this->postJson('/api/orders/create', $data);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message',
            'order' => ['id', 'user_id', 'product_id', 'quantity', 'total_price']
        ]);

        $this->assertDatabaseHas('orders', [
            'user_id' => 1,
            'product_id' => 1,
            'quantity' => 2,
        ]);

        Log::shouldHaveReceived('info')->with('Order created with ID: 1');
    }

    public function testGenerateInvoiceSuccessfully()
    {
        $order = Order::factory()->create([
            'total_price' => 210, // Przykładowa cena po uwzględnieniu tymczasowego podatku
        ]);

        $response = $this->getJson("/api/orders/{$order->id}/invoice");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message',
            'invoice'
        ]);
    }
}
