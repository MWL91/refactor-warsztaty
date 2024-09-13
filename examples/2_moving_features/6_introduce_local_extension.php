<?php

class ExistingDateClass
{
    public function __construct(
        private DateTime $currentDate
    ) {}

    public function someMethod(): void
    {
        echo "You need this: ";
    }

    public function getCurrentDate(): DateTime
    {
        return $this->currentDate;
    }
}

// Klasa nie może być zmodyfikowana (np. należy do paczki) - opcje:
// 1. Utworzenie klasy dziedziczącej, która będzie miała dodatkową metodę

class NextWeekDateClass extends ExistingDateClass
{
    public function nextWeek(): DateTime
    {
        $previousDate = clone $this->getCurrentDate();
        return $previousDate->modify("+7 days");
    }
}

// 2. Użycie wzorca adapter
class NextWeekDateAdapter
{
    public function __construct(
        private ExistingDateClass $existingDateClass
    ) {}

    public function nextWeek(): DateTime
    {
        $previousDate = clone $this->existingDateClass->getCurrentDate();
        return $previousDate->modify("+7 days");
    }

    public function someMethod(): void
    {
        $this->existingDateClass->someMethod();
    }
}

// Użycie opcja 1:
$class = new NextWeekDateClass(new DateTime());
$class->someMethod();
echo $class->nextWeek()->format('Y-m-d') . "\n";

// Użycie opcja 2:
$class = new NextWeekDateAdapter(new ExistingDateClass(new DateTime()));
$class->someMethod();
echo $class->nextWeek()->format('Y-m-d') . "\n";