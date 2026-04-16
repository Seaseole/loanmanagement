<?php

namespace App\Jobs;

use App\Actions\Loans\ProcessDeductionAction;
use App\Models\RepaymentSchedule;
use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessDailyDeductionsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Find and process all repayments due today.
     */
    public function handle(ProcessDeductionAction $processAction): void
    {
        RepaymentSchedule::where('due_date', now()->toDateString())
            ->whereIn('status', ['pending', 'partially_paid'])
            ->with('loan')
            ->each(function (RepaymentSchedule $schedule) use ($processAction) {
                $amountToCollect = $schedule->total_due - $schedule->amount_paid;

                $transaction = Transaction::create([
                    'loan_id' => $schedule->loan_id,
                    'repayment_schedule_id' => $schedule->id,
                    'type' => 'debit',
                    'amount' => $amountToCollect,
                    'payment_method' => 'RealPay Debit Order',
                    'reference' => 'PENDING-' . uniqid(),
                ]);

                $processAction->execute($transaction);
            });
    }
}
