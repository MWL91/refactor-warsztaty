<?php

class WrongExampleConsolidateConditionalExpression
{
    public function __construct(
        private int $seniority,
        private int $monthsDisabled,
        private bool $isPartTime
    )
    {
    }

    public function price(): int
    {
        if ($this->seniority < 2) {
            return 0;
        }
        if ($this->monthsDisabled > 12) {
            return 0;
        }
        if ($this->isPartTime) {
            return 0;
        }

        return 100;
    }
}

class GoodExampleConsolidateConditionalExpression
{
    public function __construct(
        private int $seniority,
        private int $monthsDisabled,
        private bool $isPartTime
    )
    {
    }

    public function price(): int
    {
        if($this->isExemptFromPayment()) {
            return 0;
        }

        return 100;
    }

    private function isExemptFromPayment(): bool
    {
        return $this->seniority < 2 || $this->monthsDisabled > 12 || $this->isPartTime;
    }
}

// Użycie
$wrongExample = new WrongExampleConsolidateConditionalExpression(1, 13, false);
echo $wrongExample->price() . "\n"; // Wynik: 0
$goodExample = new GoodExampleConsolidateConditionalExpression(1, 13, false);
echo $goodExample->price() . "\n"; // Wynik: 0

$wrongExample = new WrongExampleConsolidateConditionalExpression(5, 10, false);
echo $wrongExample->price() . "\n"; // Wynik: 100
$goodExample = new GoodExampleConsolidateConditionalExpression(5, 10, false);
echo $goodExample->price() . "\n"; // Wynik: 100