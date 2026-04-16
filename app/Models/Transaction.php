<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $fillable = [
        'loan_id',
        'repayment_schedule_id',
        'type',
        'amount',
        'payment_method',
        'reference',
        'gateway_response',
    ];

    public function loan(): BelongsTo
    {
        return $this->belongsTo(Loan::class);
    }

    public function repaymentSchedule(): BelongsTo
    {
        return $this->belongsTo(RepaymentSchedule::class);
    }

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'gateway_response' => 'encrypted:json',
        ];
    }
}
