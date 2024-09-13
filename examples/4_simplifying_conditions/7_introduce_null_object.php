<?php

class BillingPlan
{
    public static function basic(): BillingPlan
    {
        return new BillingPlan();
    }

    public function print(): void
    {
        echo "BillingPlan: ". get_class($this) . "\n";
    }
}

class Customer
{
    public function getPlan(): BillingPlan
    {
        return new BillingPlan();
    }
}

class NullPlan extends BillingPlan {
}

class NullCustomer extends Customer {
    public function isNull() {
        return true;
    }
    public function getPlan(): BillingPlan {
        return new NullPlan();
    }
}

function wrongExampleIntroduceNullObject(?Customer $customer): BillingPlan
{
    if ($customer === null) {
        $plan = new NullPlan();
    } else {
        $plan = $customer->getPlan();
    }

    $plan->print();
    return $plan;
}

function goodExampleIntroduceNullObject(?Customer $customer): BillingPlan
{
    $customer = ($customer !== null) ?
        $customer :
        new NullCustomer;

    $plan = $customer->getPlan();
    $plan->print();
    return $plan;
}

// Użycie
$customer = new Customer();
wrongExampleIntroduceNullObject($customer);
goodExampleIntroduceNullObject($customer);

wrongExampleIntroduceNullObject(null);
goodExampleIntroduceNullObject(null);