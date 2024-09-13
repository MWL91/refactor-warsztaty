<?php

/**
 * Uwaga - to jest przykład poglądowy, czasem może się zdarzyć,
 * że taka komponowalność nie będzie dobrym wyborem.
 *
 * Teraz by stworzyć obiekt Person, musimy podać obiekt Address.
 * Jeśli w obiekcie Address chcielibyśmy jeszcze dodać osobne pola będące obiektami,
 * może to doprowadzić do problemów. Te uwidacznia przykład Inline Class.
 */


class Person
{
    public function __construct(
        private string $firstName,
        private string $lastName,
        private readonly Address $address
    ) {}

    public function getFullName(): string
    {
        return "{$this->firstName} {$this->lastName}";
    }

    public function getFullAddress(): string
    {
        return $this->address->getFullAddress();
    }
}

class Address
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

// Tworzymy instancję Address
$address = new Address('Kwiatowa 15', 'Warszawa', '00-001');

// Tworzymy instancję Person z danymi osobowymi i adresem
$person = new Person('Jan', 'Kowalski', $address);

// Wyświetlamy pełne imię i nazwisko oraz adres
echo 'Full Name: ' . $person->getFullName(); // Wynik: Jan Kowalski
echo "\n";
echo 'Full Address: ' . $person->getFullAddress(); // Wynik: Kwiatowa 15, Warszawa, 00-001