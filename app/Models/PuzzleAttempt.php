<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PuzzleAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'donor_id',
        'member_id',
        'puzzle_id',
        'session_id',
        'score',
        'max_score',
        'time_taken',
        'hints_used',
        'answers',
        'feedback',
        'question_times',
        'metadata',
        'completed',
        'attempt_number',
        'status',
        'ip_address',
        'user_agent',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'answers' => 'array',
        'feedback' => 'array',
        'question_times' => 'array',
        'metadata' => 'array',
        'completed' => 'boolean',
        'score' => 'integer',
        'max_score' => 'integer',
        'hints_used' => 'integer',
        'time_taken' => 'integer',
        'attempt_number' => 'integer',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function donor()
    {
        return $this->belongsTo(Donor::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function puzzle()
    {
        return $this->belongsTo(Puzzle::class);
    }

    public function getPercentageAttribute()
    {
        if ($this->max_score == 0) return 0;
        return round(($this->score / $this->max_score) * 100, 2);
    }

    public function getGradeAttribute()
    {
        $percentage = $this->percentage;
        
        if ($percentage >= 90) return ['grade' => 'A', 'color' => 'green'];
        if ($percentage >= 80) return ['grade' => 'B', 'color' => 'blue'];
        if ($percentage >= 70) return ['grade' => 'C', 'color' => 'yellow'];
        if ($percentage >= 60) return ['grade' => 'D', 'color' => 'orange'];
        return ['grade' => 'F', 'color' => 'red'];
    }

    public function getTimeFormattedAttribute()
    {
        if (!$this->time_taken) return 'N/A';
        
        $hours = floor($this->time_taken / 3600);
        $minutes = floor(($this->time_taken % 3600) / 60);
        $seconds = $this->time_taken % 60;
        
        if ($hours > 0) {
            return sprintf('%d:%02d:%02d', $hours, $minutes, $seconds);
        }
        
        return sprintf('%d:%02d', $minutes, $seconds);
    }

    public function getCorrectAnswersCountAttribute()
    {
        $feedback = $this->feedback ?? [];
        return collect($feedback)
            ->where('is_correct', true)
            ->count();
    }

    public function getIncorrectAnswersCountAttribute()
    {
        $feedback = $this->feedback ?? [];
        return collect($feedback)
            ->where('is_correct', false)
            ->count();
    }

    public function getQuestionBreakdownAttribute()
    {
        $breakdown = [];
        $feedback = $this->feedback ?? [];
        
        foreach ($feedback as $index => $fb) {
            $breakdown[] = [
                'question_number' => $index + 1,
                'is_correct' => $fb['is_correct'] ?? false,
                'time_spent' => ($this->question_times[$index] ?? null),
                'points_earned' => $fb['points_earned'] ?? 0,
            ];
        }
        
        return $breakdown;
    }

    public function getPerformanceInsightsAttribute()
    {
        $insights = [];
        $feedback = $this->feedback ?? [];
        
        $correctCount = $this->correct_answers_count;
        $totalCount = count($feedback);
        $percentage = $this->percentage;
        
        if ($totalCount > 0) {
            if ($percentage >= 90) {
                $insights[] = 'Excellent! You\'re an expert on this topic.';
            } elseif ($percentage >= 70) {
                $insights[] = 'Good job! You have solid knowledge.';
            } elseif ($percentage >= 50) {
                $insights[] = 'Fair attempt. Review the explanations to improve.';
            } else {
                $insights[] = 'Keep learning! This topic needs more study.';
            }
        }
        
        if ($this->time_taken && $this->puzzle && $this->puzzle->average_time) {
            $avgTime = $this->puzzle->average_time;
            $timeDiff = $this->time_taken - ($this->puzzle->average_time ?? $this->time_taken);
            
            if ($timeDiff < -60) {
                $insights[] = 'You were much faster than average!';
            } elseif ($timeDiff < 0) {
                $insights[] = 'You were faster than average.';
            } elseif ($timeDiff > 60) {
                $insights[] = 'Take your time - accuracy matters more than speed.';
            }
        }
        
        return $insights;
    }

    public function scopeCompleted($query)
    {
        return $query->where('completed', true);
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeByDonor($query, $donorId)
    {
        return $query->where('donor_id', $donorId);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('created_at', now()->month);
    }
}