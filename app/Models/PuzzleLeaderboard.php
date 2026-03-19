<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PuzzleLeaderboard extends Model
{
    use HasFactory;

    protected $fillable = [
        'puzzle_id',
        'donor_id',
        'member_id',
        'best_score',
        'best_time',
        'total_attempts',
        'rank',
        'achievements',
    ];

    protected $casts = [
        'achievements' => 'array',
        'best_score' => 'integer',
        'best_time' => 'integer',
        'total_attempts' => 'integer',
        'rank' => 'integer',
    ];

    public function puzzle()
    {
        return $this->belongsTo(Puzzle::class);
    }

    public function donor()
    {
        return $this->belongsTo(Donor::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function getBestTimeFormattedAttribute()
    {
        if (!$this->best_time) return 'N/A';
        
        $minutes = floor($this->best_time / 60);
        $seconds = $this->best_time % 60;
        return sprintf('%d:%02d', $minutes, $seconds);
    }

    public function getDisplayNameAttribute()
    {
        if ($this->member) {
            return $this->member->donor->firstname . ' ' . substr($this->member->donor->lastname, 0, 1) . '.';
        }
        
        if ($this->donor) {
            return $this->donor->firstname . ' ' . substr($this->donor->lastname, 0, 1) . '.';
        }
        
        return 'Anonymous';
    }

    public function getInitialsAttribute()
    {
        if ($this->member) {
            return strtoupper(substr($this->member->donor->firstname, 0, 1) . substr($this->member->donor->lastname, 0, 1));
        }
        
        if ($this->donor) {
            return strtoupper(substr($this->donor->firstname, 0, 1) . substr($this->donor->lastname, 0, 1));
        }
        
        return 'AN';
    }

    public function getAvatarColorAttribute()
    {
        $colors = ['bg-red-500', 'bg-blue-500', 'bg-green-500', 'bg-yellow-500', 'bg-purple-500', 'bg-pink-500', 'bg-indigo-500'];
        return $colors[$this->donor_id % count($colors)];
    }

    public function scopeRanked($query)
    {
        return $query->whereNotNull('rank')->orderBy('rank');
    }

    public static function updateRankings($puzzleId)
    {
        $entries = self::where('puzzle_id', $puzzleId)
            ->orderBy('best_score', 'desc')
            ->orderBy('best_time', 'asc')
            ->get();
        
        $rank = 1;
        foreach ($entries as $entry) {
            $entry->rank = $rank++;
            $entry->save();
        }
    }
}