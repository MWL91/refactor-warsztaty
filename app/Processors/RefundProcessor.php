<?php

namespace App\Processors;

class RefundProcessor extends TransactionProcessor
{
    public function processRefund($amount, $transactionId)
    {
        // Logika przetwarzania zwrotu
        return "Processed refund of {$amount} for transaction ID: {$transactionId}.";
    }

    // RefundProcessor nie potrzebuje metod generateReceipt i logTransaction
    public function generateReceipt($transactionId)
    {
        // Metoda jest nadpisywana, ale nie jest używana
        return "Refund receipts are not generated.";
    }

    public function logTransaction($transactionId, $amount)
    {
        // Metoda jest nadpisywana, ale nie jest używana
        return "Refund transactions are not logged.";
    }
}
