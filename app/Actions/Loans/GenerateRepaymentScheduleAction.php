<?php

namespace App\Actions\Loans;

use App\Models\Loan;
use App\Models\RepaymentSchedule;
use Carbon\Carbon;

class GenerateRepaymentScheduleAction
{
    /**
     * Generate a simple reducing balance repayment schedule.
     * Note: Per PRD 4.1, reducing balance is mandatory.
     */
    public function execute(Loan $loan): void
    {
        $principal = $loan->principal_amount;
        $monthlyInterestRate = ($loan->interest_rate / 100) / 12;
        $termMonths = $loan->term_months;
        
        // Monthly Payment (PMT formula): P * [i(1+i)^n] / [(1+i)^n - 1]
        if ($monthlyInterestRate > 0) {
            $monthlyPayment = $principal * ($monthlyInterestRate * pow(1 + $monthlyInterestRate, $termMonths)) / (pow(1 + $monthlyInterestRate, $termMonths) - 1);
        } else {
            $monthlyPayment = $principal / $termMonths;
        }

        $remainingBalance = $principal;
        $startDate = $loan->disbursement_date ? Carbon::parse($loan->disbursement_date) : Carbon::now();

        for ($i = 1; $i <= $termMonths; $i++) {
            $interestDue = $remainingBalance * $monthlyInterestRate;
            $principalDue = $monthlyPayment - $interestDue;
            
            // Adjust last payment for rounding
            if ($i === $termMonths) {
                $principalDue = $remainingBalance;
                $monthlyPayment = $principalDue + $interestDue;
            }

            RepaymentSchedule::create([
                'loan_id' => $loan->id,
                'due_date' => $startDate->copy()->addMonths($i),
                'principal_due' => round($principalDue, 2),
                'interest_due' => round($interestDue, 2),
                'total_due' => round($monthlyPayment, 2),
                'status' => 'pending',
            ]);

            $remainingBalance -= $principalDue;
        }
    }
}
