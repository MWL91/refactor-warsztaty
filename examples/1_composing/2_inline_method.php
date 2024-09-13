<?php

class WrongExampleInline
{
    public function __construct(
        private int $numberOfLateDeliveries
    )
    {
    }

    public function getRating(): int {
        return ($this->moreThanFiveLateDeliveries()) ? 2 : 1;
    }

    public function moreThanFiveLateDeliveries(): bool {
        return $this->numberOfLateDeliveries > 5;
    }
}

class GoodExampleInline
{
    public function __construct(
        private int $numberOfLateDeliveries
    )
    {
    }

    public function getRating(): int {
        return ($this->numberOfLateDeliveries > 5) ? 2 : 1;
    }
}

////////////////////////////////////////////////////////////////////////////////

$wrongExampleInline = new WrongExampleInline(10);
echo $wrongExampleInline->getRating() . PHP_EOL;

$wrongExampleInline = new GoodExampleInline(10);
echo $wrongExampleInline->getRating() . PHP_EOL;