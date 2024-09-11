<?php

namespace App\Services;

use App\Models\User;
use App\Models\Subscription;
use Illuminate\Support\Facades\Log;

class EmailMarketingService
{
    // Standardowy temat
    private $defaultSubject = 'Default Subject';
    // Standardowa treść
    private $defaultBody = 'Default Body Content';
    // Standardowy nadawca
    private $defaultSender = 'no-reply@example.com';
    // Domyślny rabat
    private $defaultDiscount = 0.1; // 10% rabatu

    private $users = []; // Użytkownicy

    public function __construct(private $emailService = null)
    {
    }

    /**
     * Wysyła email marketingowy do użytkownika
     *
     * @param User $user
     * @param string $content
     * @return void
     */
    public function sendMarketingEmail(User $user, string $content): void
    {
        // Zduplikowany kod
        if ($this->emailService === null) {
            $this->emailService = new EmailService(); // Leniwa inicjalizacja
        }

        $emailData = [
            'to' => $user->email,
            'subject' => $this->defaultSubject,
            'body' => $content ?: $this->defaultBody,
            'from' => $this->defaultSender,
        ];

        // Wysyłanie e-maila
        $this->emailService->send($emailData);
    }

    // Przykład złych komentarzy i zduplikowanego kodu
    /**
     * Sends promotional email to a list of users.
     *
     * @param array $users
     * @return void
     */
    public function sendPromotionalEmails(array $users): void
    {
        if ($this->emailService === null) {
            $this->emailService = new EmailService(); // Leniwa inicjalizacja
        }

        foreach ($users as $user) {
            $emailData = [
                'to' => $user->email,
                'subject' => $this->defaultSubject,
                'body' => "Exclusive offer just for you!",
                'from' => $this->defaultSender,
            ];

            // Wysyłanie e-maila
            $this->emailService->send($emailData);
        }
    }

    // Komentarze są ogólne, a kod zduplikowany
    /**
     * Applies discount to a subscription and sends an email.
     *
     * @param Subscription $subscription
     * @return void
     */
    public function applyDiscountAndNotify(Subscription $subscription): void
    {
        // Zduplikowany kod obliczeń
        $discountedPrice = $this->calculateDiscountedPrice($subscription);
        $subscription->price = $discountedPrice;
        $subscription->save();

        // Zduplikowany kod
        if ($this->emailService === null) {
            $this->emailService = new EmailService(); // Leniwa inicjalizacja
        }

        $emailData = [
            'to' => $subscription->user->email,
            'subject' => $this->defaultSubject,
            'body' => "Discount applied! New price: $discountedPrice",
            'from' => $this->defaultSender,
        ];

        // Wysyłanie e-maila
        $this->emailService->send($emailData);
    }

    // Zduplikowany kod obliczeń
    private function calculateDiscountedPrice(Subscription $subscription): float
    {
        $basePrice = $subscription->price;
        $discountedPrice = $basePrice * (1 - $this->defaultDiscount);

        return $discountedPrice;
    }

    // Spekulacyjne uogólnienia - obsługuje różne typy e-maili
    public function sendEmail(string $type, User $user, string $content = ''): void
    {
        switch ($type) {
            case 'marketing':
                $this->sendMarketingEmail($user, $content);

                // Zduplikowany kod
                if ($this->emailService === null) {
                    $this->emailService = new EmailService(); // Leniwa inicjalizacja
                }

                $emailData = [
                    'to' => $user->email,
                    'subject' => $this->defaultSubject,
                    'body' => $content ?: $this->defaultBody,
                    'from' => $this->defaultSender,
                ];

                // Wysyłanie e-maila
                $this->emailService->send($emailData);

                break;
            case 'promotional':
                $this->sendPromotionalEmails([$user]);
                break;
            case 'discount':
                $this->applyDiscountAndNotify($user->subscription);
                break;
            default:
                Log::warning("Unknown email type: $type");
                break;
        }
    }
}