<?php

namespace App\Actions\Loans;

use App\Models\Loan;
use Illuminate\Support\Facades\DB;

class CreateLoanAction
{
    public function execute(array $data): Loan
    {
        return DB::transaction(function () use ($data) {
            $loan = Loan::create([
                'customer_id' => $data['customer_id'],
                'principal_amount' => $data['principal_amount'],
                'interest_rate' => $data['interest_rate'],
                'term_months' => $data['term_months'],
                'loan_status' => 'pending',
                'application_date' => now(),
            ]);

            // Note: Repayment schedule is usually generated after approval/disbursement
            // but we could trigger a draft schedule here if needed.

            return $loan;
        });
    }
}
