<?php

namespace App\Services;

use App\Models\User;

class AccountService
{
    public function updateAccount(User $user, array $data)
    {
        $user->name = $data['name'] ?? $user->name;
        $user->email = $data['email'] ?? $user->email;
        $user->save();

        return "Account updated for user {$user->name}.";
    }
}
