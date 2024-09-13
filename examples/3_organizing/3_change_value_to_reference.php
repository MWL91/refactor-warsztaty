<?php

class ChangeReferenceToValue
{
    private array $products = [];

    public function addProduct(Product $product): void
    {
        $this->products[] = clone $product; // Dodajemy obiekt jako wartość
    }

    public function getTotalPrice(): float
    {
        $total = 0;
        foreach ($this->products as $product) {
            $total += $product->getPrice();
        }
        return $total;
    }
}

class ChangeValueToReference
{
    private array $products = [];

    public function addProduct(Product $product): void
    {
        $this->products[] = &$product; // Dodajemy obiekt jako referencję
    }

    public function getTotalPrice(): float
    {
        $total = 0;
        foreach ($this->products as $product) {
            $total += $product->getPrice();
        }
        return $total;
    }
}

class Product
{
    public function __construct(
        private string $name,
        private float $price
    ) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }
}

// Użycie:
$product1 = new Product('Laptop', 1200);
$product2 = new Product('Mouse', 50);

$wrongExample = new ChangeReferenceToValue();
$wrongExample->addProduct($product1);
$wrongExample->addProduct($product2);

// Cena przed zmianą
echo "ChangeReferenceToValue Total Price: " . $wrongExample->getTotalPrice() . "\n"; // Wynik: 1250.00

$product1->setPrice(1000);

echo "ChangeReferenceToValue Total Price After Price Change: " . $wrongExample->getTotalPrice() . "\n"; // Wynik: 1250.00

///////

$product1 = new Product('Laptop', 1200);
$product2 = new Product('Mouse', 50);

$goodExample = new ChangeValueToReference();
$goodExample->addProduct($product1);
$goodExample->addProduct($product2);

echo "ChangeValueToReference Total Price: " . $goodExample->getTotalPrice() . "\n"; // Wynik: 1250.00

$product1->setPrice(1000);

echo "ChangeValueToReference Total Price After Price Change: " . $goodExample->getTotalPrice() . "\n"; // Wynik: 1050.00
