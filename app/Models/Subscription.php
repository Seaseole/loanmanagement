<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'plan_name',
        'price',
        'max_seats',
        'status',
        'start_date',
        'end_date',
    ];

    public function histories(): HasMany
    {
        return $this->hasMany(SubscriptionHistory::class);
    }

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }
}
