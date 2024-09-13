<?php

class BadExampleEncapsulateField
{
    public $name;
    public $age;

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'age' => $this->age,
        ];
    }
}

class GoodExampleEncapsulateField
{
    private string $name;
    private int $age;

    public function __construct(string $name, int $age)
    {
        $this->name = $name;
        $this->age = $age;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'age' => $this->age,
        ];
    }
}

// Użycie
$badExample = new BadExampleEncapsulateField();
$badExample->name = 'Jan Kowalski';
$badExample->age = 30;
var_dump($badExample->toArray());

$goodExample = new GoodExampleEncapsulateField('Jan Kowalski', 30);
var_dump($goodExample->toArray());