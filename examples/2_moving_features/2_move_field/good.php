<?php

class Account
{
    public function __construct(
        private float $balance,
        private readonly Bank $bank
    ) {}

    public function calculateInterest(): float
    {
        return $this->balance * $this->bank->getInterestRate();
    }
}

class Bank
{
    public function __construct(
        private float $interestRate
    ) {}

    public function getInterestRate(): float
    {
        return $this->interestRate;
    }
}

$bank = new Bank(0.05);
$account = new Account(1000, $bank);
echo 'Interest: ' . $account->calculateInterest();