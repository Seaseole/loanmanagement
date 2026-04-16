<?php

namespace App\Http\Controllers;

use App\Actions\Reporting\GenerateRegulatoryReportAction;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function regulatory(Request $request, GenerateRegulatoryReportAction $action)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $data = $action->execute($validated['start_date'], $validated['end_date']);

        if ($request->has('export')) {
            return $this->exportCsv($data);
        }

        return view('reports.regulatory', compact('data'));
    }

    private function exportCsv($data)
    {
        $fileName = 'regulatory_report_' . now()->format('YmdHis') . '.csv';
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Customer', 'Omang', 'Amount', 'Interest %', 'Disbursement', 'Total Repaid', 'Status'];

        $callback = function() use($data, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($data as $row) {
                fputcsv($file, [
                    $row['customer_name'],
                    $row['omang'],
                    $row['loan_amount'],
                    $row['interest_rate'],
                    $row['disbursement_date'],
                    $row['total_repaid'],
                    $row['status']
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
