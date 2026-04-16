<?php

namespace App\Actions\Loans;

use App\Contracts\PaymentGatewayInterface;
use App\Models\Transaction;
use App\Notifications\DeductionFailedNotification;
use Illuminate\Support\Facades\DB;

class ProcessDeductionAction
{
    public function __construct(protected PaymentGatewayInterface $gateway)
    {
    }

    /**
     * Process a repayment deduction via the payment gateway.
     */
    public function execute(Transaction $transaction): array
    {
        return DB::transaction(function () use ($transaction) {
            $result = $this->gateway->processDeduction($transaction);

            if ($result['success']) {
                $transaction->update([
                    'reference' => $result['reference'],
                    'gateway_response' => $result,
                ]);

                // Update repayment schedule status
                if ($transaction->repayment_schedule_id) {
                    $schedule = $transaction->repaymentSchedule;
                    $schedule->update([
                        'amount_paid' => $schedule->amount_paid + $transaction->amount,
                        'status' => ($schedule->amount_paid + $transaction->amount >= $schedule->total_due) 
                            ? 'paid' : 'partially_paid',
                    ]);
                }
            } else {
                $transaction->update([
                    'gateway_response' => $result,
                ]);

                // Notify customer of failure
                if ($transaction->loan->customer->email) {
                    $transaction->loan->customer->notify(new DeductionFailedNotification($transaction));
                }
            }

            return $result;
        });
    }
}
