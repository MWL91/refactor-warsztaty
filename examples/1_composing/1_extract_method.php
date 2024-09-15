<?php

class WrongExampleExtract {
    public function __construct(
        private string $name,
    )
    {
    }

    public function printOwing(): void {
      $this->printBanner();

      // Print details.
      print("name:  " . $this->name . "\n");
      print("amount: " . $this->getAmount() . "\n");
    }

    private function printBanner(): void
    {
        print("**************************\n");
    }

    private function getAmount(): float
    {
        // some logic...
        return 100;
    }
}

////////////////////////////////////////////////////////////////////////////////

class GoodExampleExtract {
    public function __construct(
        private string $name,
    )
    {
    }

    public function printOwing(): void {
        $this->printBanner();
        $this->printDetails($this->name, $this->getAmount());
    }

    private function printBanner(): void
    {
        print("**************************\n");
    }

    private function getAmount(): float
    {
        // some logic...
        return 100;
    }

    private function printDetails(string $name, float $amount): void
    {
        print("name:  " . $name . "\n");
        print("amount: " . $amount . "\n");
    }
}


$wrongExampleExtract = new WrongExampleExtract('John Doe');
$wrongExampleExtract->printOwing();

$wrongExampleExtract = new GoodExampleExtract('John Doe');
$wrongExampleExtract->printOwing();