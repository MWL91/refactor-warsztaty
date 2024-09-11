<?php

use App\Http\Controllers\ProductManagementController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserOrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShippingController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [UserController::class, 'registerAndNotify']);
Route::post('/order', [UserOrderController::class, 'placeOrder']);

// Trasa do dodawania nowego produktu
Route::post('/products', [ProductManagementController::class, 'addProduct']);
Route::post('/products/create-or-update', [ProductManagementController::class, 'createOrUpdateProduct']);

// Trasa do aktualizacji istniejącego produktu
Route::put('/products/{id}', [ProductManagementController::class, 'updateProduct']);

// Trasa do usuwania produktu
Route::delete('/products/{id}', [ProductManagementController::class, 'deleteProduct']);

// Trasa do wyświetlania szczegółów produktu
Route::get('/products/{id}', [ProductManagementController::class, 'getProduct']);


Route::post('/shipping/create', [ShippingController::class, 'createShipment']);
Route::post('/shipping/update', [ShippingController::class, 'updateShipmentAddress']);
Route::post('/shipping/validate', [ShippingController::class, 'validateAddress']);
Route::post('/shipping/format', [ShippingController::class, 'formatAddress']);

use App\Http\Controllers\OrderController;

Route::post('/orders/create', [OrderController::class, 'createOrder']);
Route::get('/orders/{order}/invoice', [OrderController::class, 'generateInvoice']);
