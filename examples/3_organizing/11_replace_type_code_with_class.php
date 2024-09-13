<?php

class BadExampleReplaceTypeCodeWithClass
{
    public const BLOOD_TYPE_0 = 0;
    public const BLOOD_TYPE_A = 1;
    public const BLOOD_TYPE_B = 2;
    public const BLOOD_TYPE_AB = 3;

    public function __construct(
        private int $bloodType
    )
    {
    }

    public function canTransfer(int $bloodType): bool
    {
        return match($bloodType) {
            self::BLOOD_TYPE_0, self::BLOOD_TYPE_AB => true,
            self::BLOOD_TYPE_A => $this->bloodType === self::BLOOD_TYPE_A || $this->bloodType === self::BLOOD_TYPE_AB,
            self::BLOOD_TYPE_B => $this->bloodType === self::BLOOD_TYPE_B || $this->bloodType === self::BLOOD_TYPE_AB,
            default => false, // Musimy dodać default, bo liczba może być dowolna
        };
    }
}

enum BloodType
{
    case BLOOD_TYPE_0;
    case BLOOD_TYPE_A;
    case BLOOD_TYPE_B;
    case BLOOD_TYPE_AB;
}

class GoodExampleReplaceTypeCodeWithClass
{
    public function __construct(
        private BloodType $bloodType
    )
    {
    }

    public function canTransfer(BloodType $bloodType): bool
    {
        return match($this->bloodType) {
            BloodType::BLOOD_TYPE_0, BloodType::BLOOD_TYPE_AB => true,
            BloodType::BLOOD_TYPE_A => $bloodType === BloodType::BLOOD_TYPE_A || $bloodType === BloodType::BLOOD_TYPE_AB,
            BloodType::BLOOD_TYPE_B => $bloodType === BloodType::BLOOD_TYPE_B || $bloodType === BloodType::BLOOD_TYPE_AB,
        };
    }
}

// Użycie
$badExample = new BadExampleReplaceTypeCodeWithClass(3);
var_dump($badExample->canTransfer(3)); // Wynik: true
var_dump($badExample->canTransfer(666)); // Wynik: false

$goodExample = new GoodExampleReplaceTypeCodeWithClass(BloodType::BLOOD_TYPE_A);
var_dump($goodExample->canTransfer(BloodType::BLOOD_TYPE_AB)); // Wynik: true