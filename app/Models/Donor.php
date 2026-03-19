<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Donor extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'phone',
        'country',
        'address',
        'city',
        'region',
        'postcode',
        'email_updates',
        'text_updates',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'email_updates' => 'boolean',
        'text_updates' => 'boolean',
    ];

    /**
     * Get the donations for the donor.
     */
    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class);
    }

    /**
     * Get the donor's full name.
     *
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->firstname} {$this->lastname}";
    }

    /**
     * Get total donations amount.
     */
    public function getTotalDonationsAttribute(): float
    {
        return $this->donations()
            ->where('payment_status', 'success')
            ->sum('amount');
    }

    /**
     * Get donation count.
     */
    public function getDonationCountAttribute(): int
    {
        return $this->donations()
            ->where('payment_status', 'success')
            ->count();
    }


    public function membershipPayments(): HasMany
{
    return $this->hasMany(MemberPayment::class);
}
}