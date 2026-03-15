<?php
// app/Models/Member.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'donor_id',
        'membership_type',
        'status',
        'start_date',
        'end_date',
        'renewal_reminder_sent_at',
        'renewal_count',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'renewal_reminder_sent_at' => 'datetime',
    ];

    public function donor()
    {
        return $this->belongsTo(Donor::class);
    }

    public function payments()
    {
        return $this->hasMany(MemberPayment::class);
    }

    public function isActive()
    {
        return $this->status === 'active' && $this->end_date->isFuture();
    }

    public function isExpired()
    {
        return $this->status === 'expired' || $this->end_date->isPast();
    }

    public function daysLeft()
    {
        if (!$this->isActive()) {
            return 0;
        }
        return max(0, Carbon::now()->diffInDays($this->end_date, false));
    }

    public function getRenewalDateAttribute()
    {
        return $this->end_date;
    }

    public function getPlanNameAttribute()
    {
        return $this->membership_type === 'annual' ? 'Annual Plan' : 'Monthly Plan';
    }

    public function getPriceAttribute()
    {
        return $this->membership_type === 'annual' ? 350 : 35;
    }
}