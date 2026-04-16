<?php

namespace App\Actions\Reporting;

use App\Models\Loan;
use Illuminate\Support\Facades\DB;

class GeneratePortfolioReportAction
{
    /**
     * Generate a summary report of the loan portfolio.
     */
    public function execute(): array
    {
        return [
            'total_active_loans' => Loan::where('loan_status', 'active')->count(),
            'total_principal_disbursed' => Loan::whereIn('loan_status', ['disbursed', 'active', 'closed'])
                ->sum('principal_amount'),
            'total_pending_applications' => Loan::where('loan_status', 'pending')->count(),
            'portfolio_by_status' => Loan::select('loan_status', DB::raw('count(*) as count'), DB::raw('sum(principal_amount) as total'))
                ->groupBy('loan_status')
                ->get()
                ->toArray(),
            'delinquency_rate' => $this->calculateDelinquencyRate(),
            'generated_at' => now(),
        ];
    }

    private function calculateDelinquencyRate(): float
    {
        $totalActive = Loan::whereIn('loan_status', ['active', 'delinquent'])->count();
        if ($totalActive === 0) return 0.0;

        $delinquent = Loan::where('loan_status', 'delinquent')->count();
        return round(($delinquent / $totalActive) * 100, 2);
    }
}
