<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class WordSearchPuzzle extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'grid_size',
        'grid',
        'words',
        'word_positions',
        'difficulty',
        'points',
        'time_limit',
        'attempts_allowed',
        'is_active',
        'is_featured',
        'featured_image',
        'play_count',
    ];

    protected $casts = [
        'grid' => 'array',
        'words' => 'array',
        'word_positions' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'play_count' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($puzzle) {
            if (empty($puzzle->slug)) {
                $puzzle->slug = Str::slug($puzzle->title);
            }
        });
    }

    public function attempts()
    {
        return $this->hasMany(WordSearchAttempt::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function getDifficultyBadgeAttribute()
    {
        return match($this->difficulty) {
            'beginner' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'label' => 'Beginner'],
            'intermediate' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'label' => 'Intermediate'],
            'advanced' => ['bg' => 'bg-orange-100', 'text' => 'text-orange-800', 'label' => 'Advanced'],
            'expert' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'label' => 'Expert'],
            default => ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'label' => ucfirst($this->difficulty)],
        };
    }

    public function incrementPlayCount()
    {
        $this->increment('play_count');
    }
}