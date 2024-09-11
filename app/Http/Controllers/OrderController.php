<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    protected $temporaryTaxRate;

    public function __construct()
    {
        $this->temporaryTaxRate = 0.05; // Tymczasowy podatek, tylko do celów obliczeniowych
    }

    public function createOrder(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $order = new Order();
        $order->user_id = $validatedData['user_id'];
        $order->product_id = $validatedData['product_id'];
        $order->quantity = $validatedData['quantity'];
        $order->total_price = $this->calculateTotalPrice($validatedData['product_id'], $validatedData['quantity']);

        $order->save();

        Log::info("Order created with ID: {$order->id}");

        return response()->json([
            'message' => 'Order created successfully',
            'order' => $order,
        ]);
    }

    private function calculateTotalPrice($productId, $quantity)
    {
        $productPrice = 100; // Stale cena dla przykładu
        $basePrice = $productPrice * $quantity;

        if($productId == 1) {
            $this->temporaryTaxRate = 0.1;
        }

        $totalPrice = $basePrice + ($basePrice * $this->temporaryTaxRate);

        return $totalPrice;
    }

    public function generateInvoice(Order $order)
    {
        $invoiceContent = "Invoice for order #{$order->id}. Total: {$order->total_price}";

        return response()->json([
            'message' => 'Invoice generated',
            'invoice' => base64_encode($invoiceContent)
        ]);
    }
}
