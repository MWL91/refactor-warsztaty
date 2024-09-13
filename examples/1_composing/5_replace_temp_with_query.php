<?php

// Wrong:
class WrongExampleReplaceTempWithQuery
{
    public function __construct(
        private int $quantity = 10,
        private int $itemPrice = 100
    )
    {
    }

    public function calculateDiscount(): float
    {
        $basePrice = $this->quantity * $this->itemPrice;
        if ($basePrice > 1000) {
            return $basePrice * 0.95;
        } else {
            return $basePrice * 0.98;
        }
    }
}

// Good:
class GoodExampleReplaceTempWithQuery
{
    public function __construct(
        private int $quantity = 10,
        private int $itemPrice = 100
    )
    {
    }

    public function calculateDiscount(): float
    {
        if ($this->basePrice() > 1000) {
            return $this->basePrice() * 0.95;
        } else {
            return $this->basePrice() * 0.98;
        }
    }

    private function basePrice(): int
    {
        return $this->quantity * $this->itemPrice;
    }
}

// Wrong:
$wrongExample = new WrongExampleReplaceTempWithQuery();
echo $wrongExample->calculateDiscount() . PHP_EOL;

// Good:
$wrongExample = new GoodExampleReplaceTempWithQuery();
echo $wrongExample->calculateDiscount() . PHP_EOL;