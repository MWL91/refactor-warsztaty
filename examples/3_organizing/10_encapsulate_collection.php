<?php

class BadExampleEncapsulateCollection
{
    public array $items = [];

    public function getItems(): array
    {
        return $this->items;
    }

    public function toArray(): array
    {
        return $this->items;
    }
}

class GoodExampleEncapsulateCollection
{
    private array $items = [];

    public function addItem(string $item): void
    {
        $this->items[] = $item;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function toArray(): array
    {
        return $this->items;
    }

    public function removeItem(string $string): void
    {
        $key = array_search($string, $this->items);
        if ($key !== false) {
            unset($this->items[$key]);
        }
    }
}

// Użycie przed refaktoryzacją
$badExample = new BadExampleEncapsulateCollection();
$badExample->items[] = 'Item 1';
$badExample->items[] = 'Item 2';
unset($badExample->items[0]);
var_dump($badExample->toArray());

// Użycie po refaktoryzacji
$goodExample = new GoodExampleEncapsulateCollection();
$goodExample->addItem('Item 1');
$goodExample->addItem('Item 2');
$goodExample->removeItem('Item 1');
var_dump($goodExample->toArray());
