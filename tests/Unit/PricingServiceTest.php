<?php

namespace Tests\Unit;

use App\Models\Product;
use App\PricingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PricingServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $pricingService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->pricingService = new PricingService();
    }

    public function testCalculateDiscountedPrice()
    {
        $product = Product::factory()->create(['price' => 100]);

        $price = $this->pricingService->calculateDiscountedPrice($product, 2);

        // Koszt wysyłki: 10
        // Cena po rabacie (10%): 100 * 2 * 0.90 = 180
        // Cena po dodaniu podatku (21%): 180 * 1.21 = 217.80
        // Koszt wysyłki: 15.00
        $expectedPrice = 217.80 + 10.00;
        $this->assertEquals($expectedPrice, $price);


        // Koszt wysyłki + 5
        $price = $this->pricingService->calculateDiscountedPrice($product, 2);
        $expectedPrice = 217.80 + 10.00 + 5;
        $this->assertEquals($expectedPrice, $price);
    }

    public function testCalculateSpecialOfferPrice()
    {
        $product = Product::factory()->create(['price' => 100]);

        $price = $this->pricingService->calculateSpecialOfferPrice($product, 2);
        $expectedPrice = 170 + 0;
        $this->assertEquals($expectedPrice, $price);


        $price = $this->pricingService->calculateDiscountedPrice($product, 2);
        $expectedPrice = 217.80 + 10.00 + 5;
        $this->assertNotEquals($expectedPrice, $price); // TODO: błąd wynika ze zmiany przy wywołaniu calculateSpecialOfferPrice
    }

    public function testCalculatePriceWithTax()
    {
        $product = Product::factory()->create(['price' => 100]);

        $price = $this->pricingService->calculatePriceWithTax($product, 2);
        $expectedPrice = 242 + 11.50;
        $this->assertEquals($expectedPrice, $price);

        $price = $this->pricingService->calculatePriceWithTax($product, 2);
        $expectedPrice = 242 + 13.23; // podatek zmienia się w nieskończoność...
        $this->assertEquals($expectedPrice, $price); // TODO: błąd!
    }
}
