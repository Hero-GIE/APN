<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PuzzleAchievement extends Model
{
    use HasFactory;

    protected $table = 'puzzle_achievements';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'criteria',
        'points',
        'rarity',
        'is_active',
    ];

    protected $casts = [
        'criteria' => 'array',
        'is_active' => 'boolean',
        'points' => 'integer',
    ];

    public function donors()
    {
        return $this->belongsToMany(Donor::class, 'donor_achievements')
            ->withPivot('earned_at', 'metadata')
            ->withTimestamps();
    }

    public function getRarityColorAttribute()
    {
        return match($this->rarity) {
            'common' => 'bg-gray-100 text-gray-800',
            'rare' => 'bg-blue-100 text-blue-800',
            'epic' => 'bg-purple-100 text-purple-800',
            'legendary' => 'bg-yellow-100 text-yellow-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function getIconHtmlAttribute()
    {
        if ($this->icon) {
            return "<i class='{$this->icon}'></i>";
        }
        
        return match($this->rarity) {
            'common' => '⭐',
            'rare' => '🏆',
            'epic' => '👑',
            'legendary' => '💎',
            default => '🏅',
        };
    }

    public function checkEligibility($donorId, $puzzleId = null)
    {
        $donor = Donor::find($donorId);
        if (!$donor) return false;
        
        $criteria = $this->criteria;
        
        switch ($criteria['type'] ?? null) {
            case 'total_score':
                $totalScore = PuzzleAttempt::where('donor_id', $donorId)
                    ->where('completed', true)
                    ->sum('score');
                return $totalScore >= ($criteria['threshold'] ?? 1000);
                
            case 'perfect_score':
                if (!$puzzleId) return false;
                return PuzzleAttempt::where('donor_id', $donorId)
                    ->where('puzzle_id', $puzzleId)
                    ->where('score', \DB::raw('max_score'))
                    ->exists();
                    
            case 'streak':
                $streak = $this->calculateStreak($donorId);
                return $streak >= ($criteria['days'] ?? 7);
                
            case 'speed_demon':
                if (!$puzzleId) return false;
                return PuzzleAttempt::where('donor_id', $donorId)
                    ->where('puzzle_id', $puzzleId)
                    ->where('time_taken', '<=', ($criteria['seconds'] ?? 60))
                    ->exists();
                    
            case 'mastery':
                $attempts = PuzzleAttempt::where('donor_id', $donorId)
                    ->where('puzzle_id', $puzzleId)
                    ->where('completed', true)
                    ->get();
                    
                if ($attempts->isEmpty()) return false;
                
                $avgScore = $attempts->avg('score');
                $maxScore = $attempts->first()->max_score;
                $percentage = ($avgScore / $maxScore) * 100;
                
                return $percentage >= 90;
                
            default:
                return false;
        }
    }

    protected function calculateStreak($donorId)
    {
        $attempts = PuzzleAttempt::where('donor_id', $donorId)
            ->where('completed', true)
            ->orderBy('created_at', 'desc')
            ->get();
            
        if ($attempts->isEmpty()) return 0;
        
        $streak = 1;
        $currentDate = $attempts->first()->created_at->startOfDay();
        
        foreach ($attempts->slice(1) as $attempt) {
            $attemptDate = $attempt->created_at->startOfDay();
            $diffInDays = $currentDate->diffInDays($attemptDate);
            
            if ($diffInDays == 1) {
                $streak++;
                $currentDate = $attemptDate;
            } elseif ($diffInDays > 1) {
                break;
            }
        }
        
        return $streak;
    }
}