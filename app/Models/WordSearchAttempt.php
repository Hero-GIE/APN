<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WordSearchAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'donor_id',
        'word_search_puzzle_id',
        'score',
        'found_words',
        'time_taken',
        'completed',
        'status',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'found_words' => 'array',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'completed' => 'boolean',
    ];

    public function donor()
    {
        return $this->belongsTo(Donor::class);
    }

    public function puzzle()
    {
        return $this->belongsTo(WordSearchPuzzle::class, 'word_search_puzzle_id');
    }

    public function getScorePercentageAttribute()
    {
        if ($this->score === 0) return 0;
        $totalWords = count($this->puzzle->words);
        return $totalWords > 0 ? round(($this->score / $totalWords) * 100, 2) : 0;
    }

    public function getTimeFormattedAttribute()
    {
        if (!$this->time_taken) return '0:00';
        $minutes = floor($this->time_taken / 60);
        $seconds = $this->time_taken % 60;
        return sprintf('%d:%02d', $minutes, $seconds);
    }
}