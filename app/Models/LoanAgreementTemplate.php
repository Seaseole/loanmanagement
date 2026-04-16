<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class LoanAgreementTemplate extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'content',
        'is_active',
    ];

    /**
     * Get the available merge tags.
     */
    public static function getMergeTags(): array
    {
        return [
            '{{customer_name}}' => 'Full Name of the Customer',
            '{{id_number}}' => 'Customer ID Number (Omang)',
            '{{principal}}' => 'Loan Principal Amount',
            '{{interest_rate}}' => 'Annual Interest Rate',
            '{{term_months}}' => 'Loan Term in Months',
            '{{monthly_installment}}' => 'Calculated Monthly Installment',
            '{{total_repayment}}' => 'Total Amount to be Repaid',
            '{{date}}' => 'Current Date',
        ];
    }
}
