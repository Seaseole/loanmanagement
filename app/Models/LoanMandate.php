<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoanMandate extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'loan_id',
        'gateway_mandate_id',
        'gateway_name',
        'status',
        'gateway_details',
    ];

    public function loan(): BelongsTo
    {
        return $this->belongsTo(Loan::class);
    }

    protected function casts(): array
    {
        return [
            'gateway_details' => 'encrypted:json',
        ];
    }
}
