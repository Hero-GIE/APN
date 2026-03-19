<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberPayment extends Model
{
    use HasFactory;

    protected $table = 'member_payments';

    protected $fillable = [
        'donor_id',
        'member_id',
        'transaction_id',
        'membership_type',
        'amount',
        'currency',
        'payment_method',
        'payment_status',
        'paystack_response',
        'payment_date',
        'period_start',
        'period_end',
    ];

    protected $casts = [
        'payment_date' => 'datetime',
        'period_start' => 'datetime',
        'period_end' => 'datetime',
        'amount' => 'decimal:2',
        'paystack_response' => 'array',
    ];

    public function donor()
    {
        return $this->belongsTo(Donor::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function getFormattedAmountAttribute(): string
    {
        return '$' . number_format($this->amount, 2);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->payment_status) {
            'success' => 'bg-green-100 text-green-800',
            'pending' => 'bg-yellow-100 text-yellow-800',
            'failed' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }
}