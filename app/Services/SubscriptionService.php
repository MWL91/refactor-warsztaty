<?php

namespace App\Services;

use App\Models\User;

class SubscriptionService
{
    public function subscribeUserToPlan(User $user, string $plan)
    {
        // Problem: Funkcjonalność subskrypcyjna zmienia dane konta użytkownika
        $user->subscription_plan = $plan;
        $user->save();

        return "User {$user->name} subscribed to {$plan}.";
    }
}
