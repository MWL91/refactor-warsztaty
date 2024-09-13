<?php

class Customer
{
    public function __construct(
        private string $name,
        private string $address
    )
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAddress(): string
    {
        return $this->address;
    }
}

class Order
{
    public function __construct(
        private Customer $customer,
        private string   $orderDetails
    )
    {
    }

    public function getOrderDetails(): string
    {
        return $this->orderDetails;
    }

    public function getCustomerAddress(): string
    {
        return $this->customer->getAddress();
    }
}

// Użycie:
$customer = new Customer('Jan Kowalski', '123 Main St');
$order = new Order($customer, 'Order details here');

echo "Customer Address: " . $order->getCustomerAddress() . "\n"; // Wynik: 123 Main St
