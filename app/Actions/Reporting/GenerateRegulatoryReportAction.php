<?php

namespace App\Actions\Reporting;

use App\Models\Loan;
use Illuminate\Support\Collection;

class GenerateRegulatoryReportAction
{
    /**
     * Generate a report compliant with Bank of Botswana requirements.
     */
    public function execute(string $startDate, string $endDate): Collection
    {
        return Loan::with(['customer', 'repaymentSchedules'])
            ->whereBetween('disbursement_date', [$startDate, $endDate])
            ->orWhereBetween('approval_date', [$startDate, $endDate])
            ->get()
            ->map(function ($loan) {
                return [
                    'customer_name' => $loan->customer->full_name,
                    'omang' => $loan->customer->id_number,
                    'loan_amount' => $loan->principal_amount,
                    'interest_rate' => $loan->interest_rate,
                    'disbursement_date' => $loan->disbursement_date?->format('d/m/Y'),
                    'total_repaid' => $loan->repaymentSchedules->sum('amount_paid'),
                    'outstanding_balance' => $loan->principal_amount - $loan->repaymentSchedules->sum('principal_paid'),
                    'status' => $loan->loan_status,
                ];
            });
    }
}
