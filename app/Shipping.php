<?php

namespace App;

class Shipping
{
    // Dodaj nową przesyłkę
    public function createShipment(
        $orderId,
        $recipientName,
        $street,
        $city,
        $postcode,
        $country,
        $phoneNumber
    ) {
        // Logika dodawania nowej przesyłki
        return "Shipment created for order {$orderId} to {$recipientName}, {$street}, {$city}, {$postcode}, {$country}. Contact: {$phoneNumber}.";
    }

    // Aktualizuj istniejącą przesyłkę
    public function updateShipmentAddress(
        $shipmentId,
        $street,
        $city,
        $postcode,
        $country
    ) {
        // Logika aktualizowania adresu przesyłki
        return "Shipment {$shipmentId} updated with new address: {$street}, {$city}, {$postcode}, {$country}.";
    }

    // Zweryfikuj adres dostawy
    public function validateAddress(
        $street,
        $city,
        $postcode,
        $country
    ) {
        // Prosta walidacja
        if (!$street || !$city || !$postcode || !$country) {
            return "Invalid address.";
        }

        return "Address is valid: {$street}, {$city}, {$postcode}, {$country}.";
    }

    // Zwróć pełny adres jako string
    public function formatAddress(
        $street,
        $city,
        $postcode,
        $country
    ) {
        return "{$street}, {$city}, {$postcode}, {$country}";
    }
}