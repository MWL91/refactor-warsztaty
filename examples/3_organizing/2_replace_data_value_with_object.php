<?php

class WrongExampleReplaceDataValueWithObject
{
    public function __construct(
        private string $first_name,
        private string $last_name,
        private string $email,
    )
    {
    }

    public function getFullName(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}

class GoodExampleReplaceDataValueWithObject
{
    public function __construct(
        private Name $name,
        private Email $email,
    )
    {
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getFullName(): string
    {
        return $this->name->getFullName();
    }
}

class Name
{
    private string $first_name;
    private string $last_name;

    public function __construct(
        string $first_name,
        string $last_name,
    )
    {
        if(empty($first_name) || empty($last_name)) {
            throw new InvalidArgumentException('First name and last name must not be empty');
        }

        $this->first_name = $first_name;
        $this->last_name = $last_name;
    }

    public function getFullName(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
}

class Email
{
    private string $email;
    public function __construct(
        string $email
    )
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Invalid email address');
        }

        $this->email = $email;
    }

    public function __toString(): string
    {
        return $this->email;
    }
}

// Użycie:
$wrongExample = new WrongExampleReplaceDataValueWithObject('Jan', 'Kowalski', 'jan@kowalski.pl');
echo $wrongExample->getFullName() . "\n"; // Wynik: Jan Kowalski
echo $wrongExample->getEmail() . "\n"; // Wynik: jan@kowalski.pl

$goodExample = new GoodExampleReplaceDataValueWithObject(new Name('Jan', 'Kowalski'), new Email('jan@kowalski.pl'));
echo $goodExample->getFullName() . "\n"; // Wynik: Jan Kowalski
echo $goodExample->getEmail() . "\n"; // Wynik: jan@kowalski.pl
