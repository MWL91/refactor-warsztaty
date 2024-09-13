<?php

class WrongExampleSelfEncapsulateField
{
    public function __construct(
        private int $low,
        private int $high
    )
    {
    }

    function includes($value): bool {
        return $value >= $this->low && $value <= $this->high;
    }
}

class GoodExampleSelfEncapsulateField
{
    public function __construct(
        private int $low,
        private int $high
    )
    {
    }

    function includes($value): bool {
        return $value >= $this->getLow() && $value <= $this->getHigh();
    }

    public function getLow(): int
    {
        return $this->low;
    }

    public function getHigh(): int
    {
        return $this->high;
    }
}

$wrongExample = new WrongExampleSelfEncapsulateField(1, 10);
var_dump($wrongExample->includes(5)); // true
$goodExample = new GoodExampleSelfEncapsulateField(1, 10);
var_dump($goodExample->includes(5)); // true