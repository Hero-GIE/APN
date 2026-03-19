<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Donation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'transaction_id',
        'donor_id',
        'amount',
        'payment_status',
        'payment_method',
        'currency',
        'donation_reason',
        'custom_reason',
        'paystack_response',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'paystack_response' => 'array',
    ];

    /**
     * Get the donor that owns the donation.
     */
    public function donor(): BelongsTo
    {
        return $this->belongsTo(Donor::class);
    }

    /**
     * Get the formatted amount.
     */
    public function getFormattedAmountAttribute(): string
    {
        return '$' . number_format($this->amount, 2);
    }

    /**
     * Get the status badge class.
     */
    public function getStatusBadgeAttribute(): string
    {
        return match($this->payment_status) {
            'success' => 'bg-green-100 text-green-800',
            'pending' => 'bg-yellow-100 text-yellow-800',
            'failed' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Get the donation reason badge class.
     */
    public function getReasonBadgeAttribute(): string
    {
        return match($this->donation_reason) {
            'campaign' => 'bg-purple-100 text-purple-800',
            'youth' => 'bg-blue-100 text-blue-800',
            'events' => 'bg-green-100 text-green-800',
            'advocacy' => 'bg-orange-100 text-orange-800',
            'projects' => 'bg-indigo-100 text-indigo-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Get the display name for donation reason.
     */
 public function getReasonDisplayAttribute(): string
{
    if ($this->donation_reason === 'other' && $this->custom_reason) {
        return $this->custom_reason;
    }
    
    return match($this->donation_reason) {
        'campaign' => 'Campaign Support',
        'youth' => 'Youth Initiatives',
        'events' => 'Events',
        'advocacy' => 'Advocacy Work',
        'projects' => 'Special Projects',
        default => 'General Donation',
    };
}

public function getReasonColorAttribute(): string
{
    return match($this->donation_reason) {
        'campaign' => 'bg-purple-100 text-purple-800',
        'youth' => 'bg-blue-100 text-blue-800',
        'events' => 'bg-green-100 text-green-800',
        'advocacy' => 'bg-orange-100 text-orange-800',
        'projects' => 'bg-indigo-100 text-indigo-800',
        default => 'bg-gray-100 text-gray-800',
    };
}
}