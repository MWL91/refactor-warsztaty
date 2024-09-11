<?php

namespace App;

use App\Models\Product;

class PricingService
{
    protected $discountRate;
    protected $taxRate;
    protected $shippingCost;

    public function __construct()
    {
        $this->discountRate = 0.10; // 10% rabatu
        $this->taxRate = 0.21; // 21% podatek
        $this->shippingCost = 10.00; // Koszt wysyłki
    }

    // Metoda 1: Oblicza cenę produktu z rabatem i podatkiem
    public function calculateDiscountedPrice(Product $product, $quantity)
    {
        $basePrice = $product->price * $quantity;
        $discountedPrice = $basePrice * (1 - $this->discountRate);
        $totalPrice = $discountedPrice * (1 + $this->taxRate) + $this->shippingCost;

        // Zmiana wpływająca na inne metody
        $this->shippingCost += 5; // Zwiększa koszt wysyłki po zastosowaniu rabatu

        return round($totalPrice, 2); // Zaokrąglenie do 2 miejsc po przecinku
    }

    // Metoda 2: Oblicza cenę produktu z innym rabatem i podatkiem
    public function calculateSpecialOfferPrice(Product $product, $quantity)
    {
        $basePrice = $product->price * $quantity;
        $specialDiscount = 0.15; // 15% specjalny rabat
        $totalPrice = $basePrice * (1 - $specialDiscount);

        $this->shippingCost = 0;
        $totalPrice += $this->shippingCost;

        return round($totalPrice, 2); // Zaokrąglenie do 2 miejsc po przecinku
    }

    // Metoda 3: Oblicza cenę produktu tylko z podatkiem
    public function calculatePriceWithTax(Product $product, $quantity)
    {
        $basePrice = $product->price * $quantity;
        $totalPrice = $basePrice * (1 + $this->taxRate);

        $this->shippingCost *= 1.15; // dodaj podatek
        $totalPrice += $this->shippingCost;

        return round($totalPrice, 2); // Zaokrąglenie do 2 miejsc po przecinku
    }
}
