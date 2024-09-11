<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shipping;

class ShippingController extends Controller
{
    protected $shippingService;

    public function __construct(Shipping $shippingService)
    {
        $this->shippingService = $shippingService;
    }

    // Tworzenie nowej przesyłki
    public function createShipment(Request $request)
    {
        $validatedData = $request->validate([
            'orderId' => 'required|integer',
            'recipientName' => 'required|string',
            'street' => 'required|string',
            'city' => 'required|string',
            'postcode' => 'required|string',
            'country' => 'required|string',
            'phoneNumber' => 'required|string',
        ]);

        $response = $this->shippingService->createShipment(
            $validatedData['orderId'],
            $validatedData['recipientName'],
            $validatedData['street'],
            $validatedData['city'],
            $validatedData['postcode'],
            $validatedData['country'],
            $validatedData['phoneNumber']
        );

        return response()->json(['message' => $response], 200);
    }

    // Aktualizacja adresu przesyłki
    public function updateShipmentAddress(Request $request)
    {
        $validatedData = $request->validate([
            'shipmentId' => 'required|integer',
            'street' => 'required|string',
            'city' => 'required|string',
            'postcode' => 'required|string',
            'country' => 'required|string',
        ]);

        $response = $this->shippingService->updateShipmentAddress(
            $validatedData['shipmentId'],
            $validatedData['street'],
            $validatedData['city'],
            $validatedData['postcode'],
            $validatedData['country']
        );

        return response()->json(['message' => $response], 200);
    }

    // Walidacja adresu
    public function validateAddress(Request $request)
    {
        $validatedData = $request->validate([
            'street' => 'required|string',
            'city' => 'required|string',
            'postcode' => 'required|string',
            'country' => 'required|string',
        ]);

        $response = $this->shippingService->validateAddress(
            $validatedData['street'],
            $validatedData['city'],
            $validatedData['postcode'],
            $validatedData['country']
        );

        return response()->json(['message' => $response], 200);
    }

    // Formatowanie adresu
    public function formatAddress(Request $request)
    {
        $validatedData = $request->validate([
            'street' => 'required|string',
            'city' => 'required|string',
            'postcode' => 'required|string',
            'country' => 'required|string',
        ]);

        $response = $this->shippingService->formatAddress(
            $validatedData['street'],
            $validatedData['city'],
            $validatedData['postcode'],
            $validatedData['country']
        );

        return response()->json(['message' => $response], 200);
    }
}
