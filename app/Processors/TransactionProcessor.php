<?php

namespace App\Processors;

class TransactionProcessor
{
    public function processPayment($amount, $paymentMethod)
    {
        // Logika przetwarzania płatności
        return "Processed payment of {$amount} using {$paymentMethod}.";
    }

    public function generateReceipt($transactionId)
    {
        // Logika generowania paragonu
        return "Receipt for transaction ID: {$transactionId}.";
    }

    public function logTransaction($transactionId, $amount)
    {
        // Logika logowania transakcji
        return "Logged transaction ID: {$transactionId} with amount: {$amount}.";
    }
}
