<?php
abstract class Employee
{
    abstract public function getDescription(): string;
}

class FullTimeEmployee extends Employee
{
    public function getDescription(): string
    {
        return 'Full-time employee';
    }
}

class PartTimeEmployee extends Employee
{
    public function getDescription(): string
    {
        return 'Part-time employee';
    }
}

class Intern extends Employee
{
    public function getDescription(): string
    {
        return 'Intern';
    }
}

// Poprawiony przykład: Używanie pól w jednej klasie
class GoodExampleReplaceSubclassWithFields
{
    public function __construct(
        private string $employeeType // 'full-time', 'part-time', or 'intern'
    )
    {
    }

    public function getDescription(): string
    {
        return match ($this->employeeType) {
            'full-time' => 'Full-time employee',
            'part-time' => 'Part-time employee',
            'intern' => 'Intern',
            default => 'Unknown employee type',
        };
    }
}


// Użycie
$fullTimeEmployee = new GoodExampleReplaceSubclassWithFields('full-time');
echo $fullTimeEmployee->getDescription() . "\n"; // Wynik: Full-time employee
$fullTimeEmployee = new FullTimeEmployee();
echo $fullTimeEmployee->getDescription() . "\n"; // Wynik: Full-time employee

$partTimeEmployee = new GoodExampleReplaceSubclassWithFields('part-time');
echo $partTimeEmployee->getDescription() . "\n"; // Wynik: Part-time employee
$partTimeEmployee = new PartTimeEmployee();
echo $partTimeEmployee->getDescription() . "\n"; // Wynik: Part-time employee

$intern = new GoodExampleReplaceSubclassWithFields('intern');
echo $intern->getDescription() . "\n"; // Wynik: Intern
$intern = new Intern();
echo $intern->getDescription() . "\n"; // Wynik: Intern