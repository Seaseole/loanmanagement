<?php

namespace App\Contracts;

use App\Models\Loan;
use App\Models\Transaction;

interface PaymentGatewayInterface
{
    /**
     * Create a mandate for automated deductions.
     */
    public function createMandate(Loan $loan): array;

    /**
     * Process a single repayment deduction.
     */
    public function processDeduction(Transaction $transaction): array;

    /**
     * Verify a webhook signature and payload.
     */
    public function verifyWebhook(array $payload, array $headers): bool;
}
