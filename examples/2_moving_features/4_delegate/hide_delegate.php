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

    // Zamiast zwracać obiekt Company, zwracamy menedżera bezpośrednio
    public function getManagerName(): string
    {
        return $this->company->getManager();
    }
}

// Użycie
$company = new Company("Anna Nowak");
$person = new Person("Jan Kowalski", $company);

// Klient może teraz uzyskać menedżera bezpośrednio przez Person
echo $person->getManagerName(); // Wynik: Anna Nowak