<?php

class BadExampleReplaceTypeCodeWithSubclasses
{
    private string $typeCode;

    public function __construct(string $typeCode)
    {
        $this->typeCode = $typeCode;
    }

    public function getTypeDescription(): string
    {
        return match ($this->typeCode) {
            'basic' => 'Basic Membership',
            'premium' => 'Premium Membership',
            'vip' => 'VIP Membership',
            default => 'Unknown Membership Type',
        };
    }
}

// Poprawiony przykład: Używanie klas do reprezentacji typów
abstract class MembershipType
{
    abstract public function getDescription(): string;
}

class BasicMembership extends MembershipType
{
    public function getDescription(): string
    {
        return 'Basic Membership';
    }
}

class PremiumMembership extends MembershipType
{
    public function getDescription(): string
    {
        return 'Premium Membership';
    }
}

class VIPMembership extends MembershipType
{
    public function getDescription(): string
    {
        return 'VIP Membership';
    }
}

class GoodExampleReplaceTypeCodeWithSubclasses
{
    public function __construct(
        private MembershipType $membershipType
    )
    {
    }

    public function getTypeDescription(): string
    {
        return $this->membershipType->getDescription();
    }
}

// Użycie
$badExample = new BadExampleReplaceTypeCodeWithSubclasses('premium');
echo $badExample->getTypeDescription() . "\n"; // Wynik: Premium Membership

$goodExample = new GoodExampleReplaceTypeCodeWithSubclasses(new PremiumMembership());
echo $goodExample->getTypeDescription() . "\n"; // Wynik: Premium Membership
