<?php
// app/Models/DonorAchievement.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class DonorAchievement extends Pivot
{
    use HasFactory;

    protected $table = 'donor_achievements';

    protected $fillable = [
        'donor_id',
        'achievement_id',
        'puzzle_id',
        'metadata',
        'earned_at',
    ];

    protected $casts = [
        'metadata' => 'array',
        'earned_at' => 'datetime',
    ];

    public function donor()
    {
        return $this->belongsTo(Donor::class);
    }

    public function achievement()
    {
        return $this->belongsTo(PuzzleAchievement::class, 'achievement_id');
    }

    public function puzzle()
    {
        return $this->belongsTo(Puzzle::class);
    }
}