<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Exception;

class UserOrderController extends Controller
{
    protected $discountRate;
    protected $shippingCost;
    protected $taxRate;

    public function __construct()
    {
        $this->discountRate = 0.1; // 10% zniżki dla zamówień powyżej pewnej kwoty
        $this->shippingCost = 15.99; // Koszt wysyłki standardowej
        $this->taxRate = 0.21; // Podatek 21%
    }

    public function registerUser(Request $request)
    {
        $validatedUserData = $request->validate([
            'username' => 'required|max:255',
            'email' => 'required|email',
        ]);

        $user = new User();
        $user->username = $validatedUserData['username'];
        $user->email = $validatedUserData['email'];
        $user->password = bcrypt('temporary_password');
        $user->save();

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
        ]);
    }

    public function placeOrder(Request $request)
    {
        $validatedOrderData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'shipping_type' => 'required|in:standard,express,overnight',
        ]);

        $product = Product::find($validatedOrderData['product_id']);
        if ($product->stock < $validatedOrderData['quantity']) {
            throw new Exception("Not enough stock for product.");
        }

        $order = new Order();
        $order->user_id = $validatedOrderData['user_id'];
        $order->product_id = $product->id;
        $order->quantity = $validatedOrderData['quantity'];
        $order->total_price = $this->calculateTotalPrice($product->price, $order->quantity, $validatedOrderData['shipping_type']);

        if($order->quantity > 5) {
            $this->applyDiscount($order);
        }

        $order->save();

        $this->updateProductStock($product, $order->quantity);

        $this->sendOrderConfirmationEmail(User::find($validatedOrderData['user_id']), $order);

        Log::info("User {$order->user_id} placed an order for product {$product->name}.");

        return response()->json([
            'message' => 'Order placed successfully',
            'order' => $order
        ]);
    }

    public function applyDiscount(Order $order)
    {
        if ($order->total_price > 100) {
            $order->total_price -= $order->total_price * $this->discountRate;
            $order->save();
        }
    }

    public function calculateTotalPrice($productPrice, $quantity, $shippingType)
    {
        $basePrice = $productPrice * $quantity;
        $shippingCost = $this->getShippingCost($shippingType);
        $totalPrice = $basePrice + ($basePrice * $this->taxRate) + $shippingCost;

        return $totalPrice;
    }

    protected function getShippingCost($shippingType)
    {
        switch ($shippingType) {
            case 'standard':
                return 15.99; // Koszt wysyłki standardowej
            case 'express':
                return 29.99; // Koszt wysyłki ekspresowej
            case 'overnight':
                return 49.99; // Koszt wysyłki na następny dzień
            default:
                throw new Exception('Invalid shipping type');
        }
    }

    public function updateProductStock(Product $product, $quantity)
    {
        $product->stock -= $quantity;
        $product->save();
    }

    public function sendOrderConfirmationEmail(User $user, Order $order)
    {
        Mail::raw("Order confirmation. Total price: {$order->total_price}", function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Order Confirmation');
        });
    }

    public function generateInvoice(Order $order)
    {
        // Generowanie prostego PDF z fakturą
        $pdfContent = "Invoice for order #{$order->id}. Total: {$order->total_price}";
        // Logika generowania faktury...

        return response()->json([
            'message' => 'Invoice generated',
            'invoice' => base64_encode($pdfContent)
        ]);
    }
}
