<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'donor_id',
        'member_id',
        'donation_id',
        'membership_type',
        'amount',
        'payment_date',
        'period_start',
        'period_end',
    ];

    protected $casts = [
        'payment_date' => 'datetime',
        'period_start' => 'datetime',
        'period_end' => 'datetime',
        'amount' => 'decimal:2',
    ];

    public function donor()
    {
        return $this->belongsTo(Donor::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function donation()
    {
        return $this->belongsTo(Donation::class);
    }
}