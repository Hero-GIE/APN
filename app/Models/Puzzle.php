<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class Puzzle extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'short_description',
        'description',
        'type',
        'difficulty',
        'content',
        'settings',
        'metadata',
        'base_points',
        'bonus_points',
        'featured_image',
        'thumbnail',
        'countries',
        'tags',
        'time_limit',
        'attempts_allowed',
        'hints_allowed',
        'requires_membership',
        'is_active',
        'is_featured',
        'is_timed',
        'shuffle_questions',
        'show_explanations',
        'play_count',
        'average_rating',
        'total_ratings',
        'published_at',
        'expires_at',
    ];

    protected $casts = [
        'content' => 'array',
        'settings' => 'array',
        'metadata' => 'array',
        'countries' => 'array',
        'tags' => 'array',
        'requires_membership' => 'boolean',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'is_timed' => 'boolean',
        'shuffle_questions' => 'boolean',
        'show_explanations' => 'boolean',
        'play_count' => 'integer',
        'average_rating' => 'float',
        'total_ratings' => 'integer',
        'base_points' => 'integer',
        'bonus_points' => 'integer',
        'time_limit' => 'integer',
        'attempts_allowed' => 'integer',
        'hints_allowed' => 'integer',
        'published_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($puzzle) {
            if (empty($puzzle->slug)) {
                $puzzle->slug = Str::slug($puzzle->title);
            }
        });

        static::updating(function ($puzzle) {
            if ($puzzle->isDirty('title') && !$puzzle->isDirty('slug')) {
                $puzzle->slug = Str::slug($puzzle->title);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(PuzzleCategory::class, 'category_id');
    }

    public function questions()
    {
        return $this->hasMany(PuzzleQuestion::class)->orderBy('order');
    }

    public function attempts()
    {
        return $this->hasMany(PuzzleAttempt::class);
    }

    public function leaderboard()
    {
        return $this->hasMany(PuzzleLeaderboard::class);
    }

    public function comments()
    {
        return $this->hasMany(PuzzleComment::class);
    }

    public function ratings()
    {
        return $this->hasMany(PuzzleRating::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function($q) {
                $q->whereNull('published_at')
                  ->orWhere('published_at', '<=', now());
            })
            ->where(function($q) {
                $q->whereNull('expires_at')
                  ->orWhere('expires_at', '>=', now());
            });
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByDifficulty($query, $difficulty)
    {
        return $query->where('difficulty', $difficulty);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeForMembers($query)
    {
        return $query->where('requires_membership', true);
    }

    public function scopeForEveryone($query)
    {
        return $query->where('requires_membership', false);
    }

    public function scopeSearch($query, $term)
    {
        return $query->whereFullText(['title', 'short_description', 'description'], $term);
    }

    public function getDifficultyLabelAttribute()
    {
        return match($this->difficulty) {
            'beginner' => ['label' => 'Beginner', 'color' => 'green', 'points' => 10],
            'intermediate' => ['label' => 'Intermediate', 'color' => 'blue', 'points' => 20],
            'advanced' => ['label' => 'Advanced', 'color' => 'orange', 'points' => 30],
            'expert' => ['label' => 'Expert', 'color' => 'red', 'points' => 50],
            default => ['label' => ucfirst($this->difficulty), 'color' => 'gray', 'points' => 10],
        };
    }

    public function getTypeLabelAttribute()
{
    $types = [
        'country_puzzle' => 'Country Puzzle',
        'flag_match' => 'Flag Matching',
        'capital_quiz' => 'Capital Cities Quiz',
        'heritage_quiz' => 'Heritage Quiz',
        'timeline' => 'Timeline Puzzle',
        'map_puzzle' => 'Map Puzzle',
    ];
    
    return $types[$this->type] ?? ucfirst(str_replace('_', ' ', $this->type));
}


    public function getTypeIconAttribute()
    {
        return match($this->type) {
            'country_puzzle' => 'fas fa-map',
            'flag_match' => 'fas fa-flag',
            'capital_quiz' => 'fas fa-city',
            'heritage_quiz' => 'fas fa-landmark',
            'timeline' => 'fas fa-clock',
            'map_puzzle' => 'fas fa-map-marked-alt',
            default => 'fas fa-puzzle-piece',
        };
    }

    public function getTotalPointsAttribute()
    {
        return $this->base_points + $this->bonus_points;
    }

    public function getCompletionRateAttribute()
    {
        $total = $this->attempts()->count();
        if ($total === 0) return 0;
        
        $completed = $this->attempts()->where('completed', true)->count();
        return round(($completed / $total) * 100, 2);
    }

    public function getAverageScoreAttribute()
    {
        return round($this->attempts()->where('completed', true)->avg('score') ?? 0, 2);
    }

    public function getAverageTimeAttribute()
    {
        $avgTime = $this->attempts()->where('completed', true)->avg('time_taken');
        if (!$avgTime) return null;
        
        $minutes = floor($avgTime / 60);
        $seconds = $avgTime % 60;
        return sprintf('%d:%02d', $minutes, $seconds);
    }

    public function getUserAttemptsAttribute()
    {
        if (!Auth::guard('donor')->check()) {
            return collect();
        }
        
        return $this->attempts()
            ->where('donor_id', Auth::guard('donor')->id())
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getUserBestScoreAttribute()
    {
        if (!Auth::guard('donor')->check()) {
            return 0;
        }
        
        return $this->attempts()
            ->where('donor_id', Auth::guard('donor')->id())
            ->where('completed', true)
            ->max('score') ?? 0;
    }

    public function getUserBestTimeAttribute()
    {
        if (!Auth::guard('donor')->check()) {
            return null;
        }
        
        return $this->attempts()
            ->where('donor_id', Auth::guard('donor')->id())
            ->where('completed', true)
            ->min('time_taken');
    }

    public function getUserRankAttribute()
    {
        if (!Auth::guard('donor')->check()) {
            return null;
        }
        
        $leaderboard = $this->leaderboard()
            ->where('donor_id', Auth::guard('donor')->id())
            ->first();
            
        return $leaderboard?->rank;
    }

    public function getRemainingAttemptsAttribute()
    {
        if (!Auth::guard('donor')->check()) {
            return 0;
        }
        
        $attemptCount = $this->attempts()
            ->where('donor_id', Auth::guard('donor')->id())
            ->count();
            
        return max(0, $this->attempts_allowed - $attemptCount);
    }

    public function getHasAttemptsLeftAttribute()
    {
        return $this->remaining_attempts > 0;
    }

    public function getCanPlayAttribute()
    {
        if ($this->requires_membership) {
            if (!Auth::guard('donor')->check()) return false;
            
            $member = Member::where('donor_id', Auth::guard('donor')->id())
                ->where('status', 'active')
                ->exists();
                
            if (!$member) return false;
        }
        
        return $this->is_active && $this->has_attempts_left;
    }

    public function getRatingDistributionAttribute()
    {
        $distribution = [
            5 => 0,
            4 => 0,
            3 => 0,
            2 => 0,
            1 => 0,
        ];
        
        $ratings = $this->ratings()
            ->selectRaw('rating, COUNT(*) as count')
            ->groupBy('rating')
            ->get();
            
        foreach ($ratings as $rating) {
            $distribution[$rating->rating] = $rating->count;
        }
        
        return $distribution;
    }

    public function incrementPlayCount()
    {
        $this->increment('play_count');
    }

    public function updateRating($newRating)
    {
        $total = $this->total_ratings * $this->average_rating;
        $total += $newRating;
        $this->total_ratings += 1;
        $this->average_rating = $total / $this->total_ratings;
        $this->save();
    }

    public function getNextPuzzle()
    {
        return self::where('category_id', $this->category_id)
            ->where('id', '>', $this->id)
            ->where('is_active', true)
            ->orderBy('id')
            ->first();
    }

    public function getPreviousPuzzle()
    {
        return self::where('category_id', $this->category_id)
            ->where('id', '<', $this->id)
            ->where('is_active', true)
            ->orderBy('id', 'desc')
            ->first();
    }

    public function getRelatedPuzzles($limit = 3)
    {
        return self::where('category_id', $this->category_id)
            ->where('id', '!=', $this->id)
            ->where('is_active', true)
            ->inRandomOrder()
            ->limit($limit)
            ->get();
    }

    public function loadQuestions()
    {
        $questions = $this->questions()->where('is_active', true)->get();
        
        if ($this->shuffle_questions) {
            $questions = $questions->shuffle();
        }
        
        return $questions;
    }

    public function toGameArray()
    {
        $questions = $this->loadQuestions();
        
        return [
            'id' => $this->id,
            'title' => $this->title,
            'type' => $this->type,
            'difficulty' => $this->difficulty_label,
            'time_limit' => $this->time_limit,
            'hints_allowed' => $this->hints_allowed,
            'questions' => $questions->map(function($q) {
                return [
                    'id' => $q->id,
                    'question' => $q->question,
                    'options' => $q->options_array,
                    'points' => $q->points,
                    'image' => $q->image,
                ];
            }),
            'metadata' => [
                'total_points' => $questions->sum('points'),
                'question_count' => $questions->count(),
                'has_timer' => $this->is_timed,
                'shuffle_questions' => $this->shuffle_questions,
            ],
        ];
    }
}