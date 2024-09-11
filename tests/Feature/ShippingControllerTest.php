<?php

namespace Tests\Feature;

use Tests\TestCase;

class ShippingControllerTest extends TestCase
{
    public function testCreateShipment()
    {
        $response = $this->postJson('/api/shipping/create', [
            'orderId' => 1,
            'recipientName' => 'John Doe',
            'street' => '123 Main St',
            'city' => 'Anytown',
            'postcode' => '12345',
            'country' => 'USA',
            'phoneNumber' => '555-1234',
        ]);

        $response->assertStatus(200);
        $response->assertSee('Shipment created for order 1 to John Doe, 123 Main St, Anytown, 12345, USA.');
    }

    public function testUpdateShipmentAddress()
    {
        $response = $this->postJson('/api/shipping/update', [
            'shipmentId' => 1,
            'street' => '456 Oak St',
            'city' => 'Othertown',
            'postcode' => '54321',
            'country' => 'Canada',
        ]);

        $response->assertStatus(200);
        $response->assertSee('Shipment 1 updated with new address: 456 Oak St, Othertown, 54321, Canada.');
    }

    public function testValidateAddress()
    {
        $response = $this->postJson('/api/shipping/validate', [
            'street' => '789 Pine St',
            'city' => 'Sometown',
            'postcode' => '67890',
            'country' => 'Mexico',
        ]);

        $response->assertStatus(200);
        $response->assertSee('Address is valid: 789 Pine St, Sometown, 67890, Mexico.');
    }

    public function testFormatAddress()
    {
        $response = $this->postJson('/api/shipping/format', [
            'street' => '101 Maple St',
            'city' => 'Anycity',
            'postcode' => '24680',
            'country' => 'UK',
        ]);

        $response->assertStatus(200);
        $response->assertSee('101 Maple St, Anycity, 24680, UK');
    }
}
