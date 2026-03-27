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
        'last_reminder_sent_at', // Add this field if you have it
    ];

    protected $casts = [
        'start_date'                => 'datetime',
        'end_date'                  => 'datetime',
        'renewal_reminder_sent_at'  => 'datetime',
        'last_reminder_sent_at'     => 'datetime',
    ];

    public function donor()
    {
        return $this->belongsTo(Donor::class);
    }
    
    public function payments()
    {
        return $this->hasMany(MemberPayment::class);
    }

    /**
     * Check if membership is currently active
     */
    public function isActive(): bool
    {
        // Status must be 'active' AND end_date must be in the future (or null)
        if ($this->status !== 'active') {
            return false;
        }
        
        // If no end date, assume it's active (lifetime membership)
        if (!$this->end_date) {
            return true;
        }
        
        // Check if end date is in the future
        return $this->end_date->isFuture();
    }

    /**
     * Check if membership is expired
     */
    public function isExpired(): bool
    {
        // If status is already marked as expired
        if ($this->status === 'expired') {
            return true;
        }
        
        // If no end date, it's not expired
        if (!$this->end_date) {
            return false;
        }
        
        // Check if end date is in the past
        return $this->end_date->isPast();
    }

    /**
     * Get days left until expiration (for active members only)
     */
    public function daysLeft(): int
    {
        // Only calculate for active members
        if (!$this->isActive()) {
            return 0;
        }
        
        // If no end date (lifetime membership)
        if (!$this->end_date) {
            return 999; // Or some large number, or return 0
        }
        
        // Calculate days difference (positive if end_date is in future)
        $now = Carbon::now()->startOfDay();
        $endDate = $this->end_date->startOfDay();
        
        // If end date is in the past, return 0
        if ($endDate->lt($now)) {
            return 0;
        }
        
        return $now->diffInDays($endDate);
    }
    
    /**
     * Check if membership is expiring soon (within 7 days)
     */
    public function isExpiringSoon(): bool
    {
        $daysLeft = $this->daysLeft();
        return $daysLeft > 0 && $daysLeft <= 7;
    }
    
    /**
     * Get days until expiration (can be negative for expired)
     */
    public function daysUntilExpiration(): int
    {
        if (!$this->end_date) {
            return 0;
        }
        
        $now = Carbon::now()->startOfDay();
        $endDate = $this->end_date->startOfDay();
        
        return $now->diffInDays($endDate, false);
    }

    public function getRenewalDateAttribute()
    {
        return $this->end_date;
    }

    public function getPlanNameAttribute(): string
    {
        return $this->membership_type === 'yearly' ? 'Yearly Plan' : 'Monthly Plan';
    }

    public function getPriceAttribute(): int
    {
        return $this->membership_type === 'yearly' ? 299 : 29;
    }
    
    /**
     * Get total paid amount
     */
    public function getTotalPaidAttribute(): float
    {
        return $this->payments()
            ->where('payment_status', 'success')
            ->sum('amount');
    }
    
    /**
     * Mark reminder as sent
     */
    public function markReminderSent(): void
    {
        $this->update(['last_reminder_sent_at' => now()]);
    }
    
    /**
     * Check if reminder was sent in the last N days
     */
    public function wasReminderSentRecently(int $days = 3): bool
    {
        if (!$this->last_reminder_sent_at) {
            return false;
        }
        return Carbon::parse($this->last_reminder_sent_at)->diffInDays(now()) < $days;
    }
}