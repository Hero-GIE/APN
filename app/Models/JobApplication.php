<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobApplication extends Model
{
    protected $fillable = [
        'job_id',
        'donor_id',
        'status',
        'cover_letter',
        'resume_path',
        'notes',
        'applied_at'
    ];

    protected $casts = [
        'applied_at' => 'datetime'
    ];

    public function job(): BelongsTo
    {
        return $this->belongsTo(JobOpportunity::class, 'job_id');
    }

    public function donor(): BelongsTo
    {
        return $this->belongsTo(Donor::class);
    }
}