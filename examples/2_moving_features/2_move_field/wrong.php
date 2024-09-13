<?php

class Account
{
    public function __construct(
        private float $balance,
        private float $interestRate
    ) {}

    public function calculateInterest(): float
    {
        return $this->balance * $this->interestRate;
    }
}

class Bank
{
}

$account = new Account(1000, 0.05);
echo 'Interest: ' . $account->calculateInterest(); // Wynik: 50 (5% od 1000)