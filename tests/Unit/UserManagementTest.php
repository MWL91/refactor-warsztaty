<?php

namespace Tests\Unit;

use App\Models\User;
use App\Services\AccountService;
use App\Services\SubscriptionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    protected $accountService;
    protected $subscriptionService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->accountService = new AccountService();
        $this->subscriptionService = new SubscriptionService();
    }

    public function testAccountUpdateAndSubscriptionConflict()
    {
        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        // Update account details
        $this->accountService->updateAccount($user, [
            'name' => 'John Smith',
            'email' => 'john.smith@example.com',
        ]);

        // Subscribe user to a plan
        $this->subscriptionService->subscribeUserToPlan($user, 'Premium');

        // Refresh user data
        $user->refresh();

        // Check if account update was overwritten by subscription service
        $this->assertEquals('John Smith', $user->name);
        $this->assertEquals('john.smith@example.com', $user->email);
        $this->assertEquals('Premium', $user->subscription_plan);
    }
}
