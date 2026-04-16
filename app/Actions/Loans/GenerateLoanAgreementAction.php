<?php

namespace App\Actions\Loans;

use App\Models\Loan;
use App\Models\LoanAgreementTemplate;
use App\Models\Document;
use Illuminate\Support\Facades\DB;

class GenerateLoanAgreementAction
{
    /**
     * Generate a loan agreement from a template and save it as a document.
     */
    public function execute(Loan $loan, LoanAgreementTemplate $template): Document
    {
        return DB::transaction(function () use ($loan, $template) {
            $content = $template->content;
            $data = $this->prepareMergeData($loan);

            foreach ($data as $tag => $value) {
                $content = str_replace($tag, $value, $content);
            }

            return Document::create([
                'documentable_type' => Loan::class,
                'documentable_id' => $loan->id,
                'name' => 'Loan Agreement - ' . $template->name . ' - ' . now()->format('Y-m-d'),
                'file_path' => 'generated/' . uniqid() . '.html',
                'mime_type' => 'text/html',
                'file_size' => strlen($content),
                'type' => 'LOAN_AGREEMENT',
                'content' => $content,
            ]);
            
            // Note: In a production environment, we would use a PDF library like DomPDF 
            // or Snappy to generate a PDF file from the HTML content and save it to storage.
        });
    }

    protected function prepareMergeData(Loan $loan): array
    {
        $monthlyInstallment = 0;
        $totalRepayment = 0;

        if ($loan->repaymentSchedules->isNotEmpty()) {
            $monthlyInstallment = $loan->repaymentSchedules->first()->total_due;
            $totalRepayment = $loan->repaymentSchedules->sum('total_due');
        }

        return [
            '{{customer_name}}' => $loan->customer->full_name,
            '{{id_number}}' => $loan->customer->id_number,
            '{{principal}}' => 'P' . number_format($loan->principal_amount, 2),
            '{{interest_rate}}' => $loan->interest_rate . '%',
            '{{term_months}}' => $loan->term_months,
            '{{monthly_installment}}' => 'P' . number_format($monthlyInstallment, 2),
            '{{total_repayment}}' => 'P' . number_format($totalRepayment, 2),
            '{{date}}' => now()->format('d/m/Y'),
        ];
    }
}
