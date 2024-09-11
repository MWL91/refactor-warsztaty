<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Subscription;
use App\Services\EmailMarketingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class EmailMarketingServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $emailMarketingService;
    protected $emailServiceMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->emailServiceMock = Mockery::mock('App\Services\EmailService');
        $this->emailMarketingService = new EmailMarketingService($this->emailServiceMock);
    }

    public function testSendMarketingEmail()
    {
        $user = User::factory()->create(['email' => 'user@example.com']);

        $this->emailServiceMock
            ->shouldReceive('send')
            ->once()
            ->with([
                'to' => 'user@example.com',
                'subject' => 'Default Subject',
                'body' => 'Default Body Content',
                'from' => 'no-reply@example.com',
            ]);

        $this->emailMarketingService->sendMarketingEmail($user, '');
    }

    public function testSendPromotionalEmails()
    {
        $user = User::factory()->create(['email' => 'user@example.com']);

        $this->emailServiceMock
            ->shouldReceive('send')
            ->once()
            ->with([
                'to' => 'user@example.com',
                'subject' => 'Default Subject',
                'body' => 'Exclusive offer just for you!',
                'from' => 'no-reply@example.com',
            ]);

        $this->emailMarketingService->sendPromotionalEmails([$user]);
    }

    public function testApplyDiscountAndNotify()
    {
        $subscription = Subscription::factory()->create(['price' => 100]);

        $this->emailServiceMock
            ->shouldReceive('send')
            ->once()
            ->with([
                'to' => $subscription->user->email,
                'subject' => 'Default Subject',
                'body' => 'Discount applied! New price: 90',
                'from' => 'no-reply@example.com',
            ]);

        $this->emailMarketingService->applyDiscountAndNotify($subscription);

        $subscription->refresh();
        $this->assertEquals(90, $subscription->price);
    }

    public function testSendEmail()
    {
        $user = User::factory()->create(['email' => 'user@example.com']);
        $subscription = Subscription::factory()->create(['price' => 100, 'user_id' => $user->id]);

        // Test marketing email
        $this->emailServiceMock
            ->shouldReceive('send')
            ->with([
                'to' => 'user@example.com',
                'subject' => 'Default Subject',
                'body' => 'Marketing email content',
                'from' => 'no-reply@example.com',
            ]);

        $this->emailMarketingService = new EmailMarketingService($this->emailServiceMock);
        $this->emailMarketingService->sendEmail('marketing', $user, 'Marketing email content');

        // Test promotional email
        $this->emailServiceMock
            ->shouldReceive('send')
            ->with([
                'to' => 'user@example.com',
                'subject' => 'Default Subject',
                'body' => 'Exclusive offer just for you!',
                'from' => 'no-reply@example.com',
            ]);

        $this->emailMarketingService->sendEmail('promotional', $user);

        // Test discount email
        $this->emailServiceMock
            ->shouldReceive('send')
            ->once()
            ->with([
                'to' => $subscription->user->email,
                'subject' => 'Default Subject',
                'body' => 'Discount applied! New price: 90',
                'from' => 'no-reply@example.com',
            ]);

        $this->emailMarketingService->sendEmail('discount', $user);
    }
}
