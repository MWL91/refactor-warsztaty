<?php


// Przykład przed refaktoryzacją (Unidirectional Association)
class BadExampleChangeUnidirectionalAssociationToBidirectionalCustomer
{
    private array $orders = [];

    public function __construct(
        private string $name,
        private string $email
    )
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function addOrder(BadExampleChangeUnidirectionalAssociationToBidirectionalOrder $order): void
    {
        $this->orders[] = $order;
    }

    public function getOrders(): array
    {
        return $this->orders;
    }
}

class BadExampleChangeUnidirectionalAssociationToBidirectionalOrder
{
    public function __construct(
        private BadExampleChangeUnidirectionalAssociationToBidirectionalCustomer $customer,
        private string                                                           $details
    )
    {
    }

    public function getCustomer(): BadExampleChangeUnidirectionalAssociationToBidirectionalCustomer
    {
        return $this->customer;
    }

    public function getDetails(): string
    {
        return $this->details;
    }
}

// Przykład użycia przed refaktoryzacją
$customer = new BadExampleChangeUnidirectionalAssociationToBidirectionalCustomer('Jan Kowalski', 'jan@kowalski.pl');
$order = new BadExampleChangeUnidirectionalAssociationToBidirectionalOrder($customer, 'Order details here');
$customer->addOrder($order);

echo "Bad Example - Customer Orders Count: " . count($customer->getOrders()) . "\n"; // Wynik: 1


// Przykład po refaktoryzacji (Bidirectional Association)
class GoodExampleChangeUnidirectionalAssociationToBidirectionalCustomer
{
    private array $orders = [];

    public function __construct(
        private string $name,
        private string $email
    )
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function addOrder(GoodExampleChangeUnidirectionalAssociationToBidirectionalOrder $order): void
    {
        $this->orders[] = $order;
        $order->setCustomer($this); // Ustawiamy referencję w obiekcie Order
    }

    public function getOrders(): array
    {
        return $this->orders;
    }
}

class GoodExampleChangeUnidirectionalAssociationToBidirectionalOrder
{
    private ?GoodExampleChangeUnidirectionalAssociationToBidirectionalCustomer $customer = null;

    public function __construct(
        private string $details
    )
    {
    }

    public function setCustomer(GoodExampleChangeUnidirectionalAssociationToBidirectionalCustomer $customer): void
    {
        $this->customer = $customer;
    }

    public function getCustomer(): ?GoodExampleChangeUnidirectionalAssociationToBidirectionalCustomer
    {
        return $this->customer;
    }

    public function getDetails(): string
    {
        return $this->details;
    }
}

// Przykład użycia po refaktoryzacji
$customer = new GoodExampleChangeUnidirectionalAssociationToBidirectionalCustomer('Jan Kowalski', 'jan@kowalski.pl');
$order = new GoodExampleChangeUnidirectionalAssociationToBidirectionalOrder('Order details here');
$customer->addOrder($order);

echo "Good Example - Customer Orders Count: " . count($customer->getOrders()) . "\n"; // Wynik: 1
echo "Good Example - Order Customer: " . ($order->getCustomer()->getName() ?? 'No customer') . "\n"; // Wynik: Jan Kowalski
