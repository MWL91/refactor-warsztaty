<?php

/**
 * Uwaga - to jest przykład poglądowy, czasem może się zdarzyć,
 * że obiekt jest generyczny i adres nie dotyczy jedynie osoby a np. firmy itp.
 *
 * Tracimy możliwość lepszej eknapsulacji, ale zyskujemy możliwość łatwiejszego
 * tworzenia instancji klasy. Jeśli jednak obiekt jest generyczny wypadałoby
 * stworzyć do tego osobną klasę - przykłąd w Extract Class.
 */

class Person implements Location
{
    public function __construct(
        private string $firstName,
        private string $lastName,
        private string $street,
        private string $city,
        private string $postalCode
    ) {}

    public function getFullName(): string
    {
        return "{$this->firstName} {$this->lastName}";
    }

    public function getFullAddress(): string
    {
        return "{$this->street}, {$this->city}, {$this->postalCode}";
    }
}

class Address implements Location
{
    public function __construct(
        private string $street,
        private string $city,
        private string $postalCode
    ) {}

    public function getFullAddress(): string
    {
        return "{$this->street}, {$this->city}, {$this->postalCode}";
    }
}

interface Location
{
    public function getFullAddress(): string;
}

$person = new Person('Jan', 'Kowalski', 'Kwiatowa 15', 'Warszawa', '00-001');

echo 'Full Name: ' . $person->getFullName(); // Wynik: Jan Kowalski
echo "\n";
echo 'Full Address: ' . $person->getFullAddress(); // Wynik: Kwiatowa 15, Warszawa, 00-001