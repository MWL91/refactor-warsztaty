<?php

class Company
{
    public function __construct(
        private string $manager
    ) {}

    public function getManager(): string
    {
        return $this->manager;
    }
}

class Person
{
    public function __construct(
        private string $name,
        private Company $company
    ) {}

    public function getCompany(): Company
    {
        return $this->company;
    }
}

// Użycie
$company = new Company("Anna Nowak");
$person = new Person("Jan Kowalski", $company);

// Uzyskujemy nazwisko menedżera bezpośrednio przez Company - łamiemy zasadę Demeter
echo $person->getCompany()->getManager(); // Wynik: Anna Nowak