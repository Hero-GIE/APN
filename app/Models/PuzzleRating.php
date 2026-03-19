<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PuzzleRating extends Model
{
    use HasFactory;

    protected $table = 'puzzle_ratings';

    protected $fillable = [
        'puzzle_id',
        'donor_id',
        'rating',
        'review',
        'feedback',
    ];

    protected $casts = [
        'rating' => 'integer',
        'feedback' => 'array',
    ];

    public function puzzle()
    {
        return $this->belongsTo(Puzzle::class);
    }

    public function donor()
    {
        return $this->belongsTo(Donor::class);
    }
}