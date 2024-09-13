<?php

interface MembershipStrategy
{
    public function getDescription(): string;
}

class BasicMembershipStrategy implements MembershipStrategy
{
    public function getDescription(): string
    {
        return 'Basic Membership';
    }
}

class PremiumMembershipStrategy implements MembershipStrategy
{
    public function getDescription(): string
    {
        return 'Premium Membership';
    }
}

class VIPMembershipStrategy implements MembershipStrategy
{
    public function getDescription(): string
    {
        return 'VIP Membership';
    }
}

class MembershipContext
{
    private MembershipStrategy $strategy;

    public function __construct(MembershipStrategy $strategy)
    {
        $this->strategy = $strategy;
    }

    public function getTypeDescription(): string
    {
        return $this->strategy->getDescription();
    }
}

// Użycie
$basicMembership = new BasicMembershipStrategy();
$premiumMembership = new PremiumMembershipStrategy();
$vipMembership = new VIPMembershipStrategy();

$context = new MembershipContext($basicMembership);
echo $context->getTypeDescription() . "\n"; // Wynik: Basic Membership

$context = new MembershipContext($premiumMembership);
echo $context->getTypeDescription() . "\n"; // Wynik: Premium Membership

$context = new MembershipContext($vipMembership);
echo $context->getTypeDescription() . "\n"; // Wynik: VIP Membership
