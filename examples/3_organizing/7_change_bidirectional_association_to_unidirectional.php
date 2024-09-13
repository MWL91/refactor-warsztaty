<?php

class BadExampleChangeBidirectionalAssociationToUnidirectionalCustomer
{
    private array $orders = [];

    public function __construct(
        private string $name,
        private string $email
    ) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function addOrder(BadExampleChangeBidirectionalAssociationToUnidirectionalOrder $order): void
    {
        $this->orders[] = $order;
        $order->setCustomer($this); // Ustawiamy referencję w obiekcie Order
    }

    public function getOrders(): array
    {
        return $this->orders;
    }
}

class BadExampleChangeBidirectionalAssociationToUnidirectionalOrder
{
    private ?BadExampleChangeBidirectionalAssociationToUnidirectionalCustomer $customer = null;

    public function __construct(
        private string $details
    ) {}

    public function setCustomer(BadExampleChangeBidirectionalAssociationToUnidirectionalCustomer $customer): void
    {
        $this->customer = $customer;
    }

    public function getCustomer(): ?BadExampleChangeBidirectionalAssociationToUnidirectionalCustomer
    {
        return $this->customer;
    }

    public function getDetails(): string
    {
        return $this->details;
    }
}

// Użycie przed refaktoryzacją:
$customer = new BadExampleChangeBidirectionalAssociationToUnidirectionalCustomer('Jan Kowalski', 'jan@kowalski.pl');
$order = new BadExampleChangeBidirectionalAssociationToUnidirectionalOrder('Order details here');
$customer->addOrder($order);

echo "Bad Example - Customer Orders Count: " . count($customer->getOrders()) . "\n"; // Wynik: 1
echo "Bad Example - Order Customer: " . ($order->getCustomer()->getName() ?? 'No customer') . "\n"; // Wynik: Jan Kowalski
