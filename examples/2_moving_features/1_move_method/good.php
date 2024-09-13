<?php
class Order
{
    public function __construct(
        private array $items,
        private Customer $customer
    )
    {
    }

    public function calculateTotal()
    {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item->getPrice();
        }

        // jeszcze lepiej byłoby z decoratorem, ale tu byłby to overkill
        return $this->customer->applyDiscount($total);
    }
}

class Customer
{
    public function __construct(
        private string $name,
        private bool $isPremium
    )
    {
    }

    public function applyDiscount(float $total): float
    {
        return $this->isPremium ? $total * 0.9 : $total;
    }
}

class Item
{
    private $price;

    public function __construct($price)
    {
        $this->price = $price;
    }

    public function getPrice()
    {
        return $this->price;
    }
}

// Tworzymy produkty
$item1 = new Item(100);
$item2 = new Item(200);

// Tworzymy klientów
$regularCustomer = new Customer('Jan Kowalski', false);
$premiumCustomer = new Customer('Anna Nowak', true);

$order1 = new Order([$item1, $item2], $regularCustomer);
$order2 = new Order([$item1, $item2], $premiumCustomer);

echo $order1->calculateTotal(); // 300
echo PHP_EOL;
echo $order2->calculateTotal(); // 270