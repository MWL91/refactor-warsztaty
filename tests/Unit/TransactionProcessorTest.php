<?php

namespace Tests\Unit;

use App\Processors\RefundProcessor;
use PHPUnit\Framework\TestCase;
use App\Processors\TransactionProcessor;

class TransactionProcessorTest extends TestCase
{
    public function test_process_payment()
    {
        $processor = new TransactionProcessor();
        $result = $processor->processPayment(100, 'credit card');

        $this->assertEquals('Processed payment of 100 using credit card.', $result);
    }

    public function test_generate_receipt()
    {
        $processor = new TransactionProcessor();
        $result = $processor->generateReceipt(12345);

        $this->assertEquals('Receipt for transaction ID: 12345.', $result);
    }

    public function test_log_transaction()
    {
        $processor = new TransactionProcessor();
        $result = $processor->logTransaction(12345, 100);

        $this->assertEquals('Logged transaction ID: 12345 with amount: 100.', $result);
    }

    public function test_process_refund()
    {
        $processor = new RefundProcessor();
        $result = $processor->processRefund(50, 12345);

        $this->assertEquals('Processed refund of 50 for transaction ID: 12345.', $result);
    }

    public function test_generate_receipt_refund()
    {
        $processor = new RefundProcessor();
        $result = $processor->generateReceipt(12345);

        $this->assertEquals('Refund receipts are not generated.', $result);
    }

    public function test_log_transaction_refund()
    {
        $processor = new RefundProcessor();
        $result = $processor->logTransaction(12345, 50);

        $this->assertEquals('Refund transactions are not logged.', $result);
    }
}
