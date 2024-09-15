<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductManagementControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testAddProductSuccessfully()
    {
        // Given:
        $payload = [
            'name' => 'Test Product',
            'price' => 99.99,
            'stock' => 10,
            'tags' => ['electronics', 'gadgets'],
        ];

        // When:
        $response = $this->postJson('/api/products', $payload);

        // Then:
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message',
            'product' => ['id', 'name', 'price', 'stock', 'tags']
        ]);

        $this->assertDatabaseHas('products', [
            'name' => 'Test Product',
            'price' => 99.99,
            'stock' => 10,
        ]);
    }

    public function testUpdateProductSuccessfully()
    {
        $product = Product::factory()->create();

        $response = $this->putJson('/api/products/' . $product->id, [
            'name' => 'Updated Product',
            'price' => 89.99,
            'stock' => 15,
            'tags' => ['updated', 'tag'],
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message',
            'product' => ['id', 'name', 'price', 'stock', 'tags']
        ]);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated Product',
            'price' => 89.99,
            'stock' => 15,
        ]);
    }

    public function testDeleteProductSuccessfully()
    {
        $product = Product::factory()->create();

        $response = $this->deleteJson('/api/products/' . $product->id);

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Product deleted successfully',
        ]);

        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
        ]);
    }

    public function testGetProductSuccessfully()
    {
        $product = Product::factory()->create();

        $response = $this->getJson('/api/products/' . $product->id);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'product' => ['id', 'name', 'price', 'stock', 'tags']
        ]);
    }
}
