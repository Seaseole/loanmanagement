<?php

namespace App\Http\Controllers;

use App\Actions\Reporting\GeneratePortfolioReportAction;
use App\Models\Loan;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    public function __invoke(GeneratePortfolioReportAction $reportAction)
    {
        $report = $reportAction->execute();
        
        $recentLoans = Loan::with('customer')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact('report', 'recentLoans'));
    }
}
