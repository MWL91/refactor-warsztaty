<?php

$anOrder = new class {
    public function basePrice(): int
    {
        return 1001;
    }

    public function discounted(): bool
    {
        return $this->basePrice() > 1000;
    }
};

// Wrong:
$basePrice = $anOrder->basePrice();
if($basePrice > 1000) {
    echo 'Discount'.PHP_EOL;
}

// Good:
if($anOrder->basePrice() > 1000) {
    echo 'Discount'.PHP_EOL;
}

// Even better, but warning -> logic moved to order - business decision required!
if($anOrder->discounted()) {
    echo 'Discount'.PHP_EOL;
}