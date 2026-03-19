<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PuzzleCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'color',
        'display_order',
        'is_active',
        'metadata',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'display_order' => 'integer',
        'metadata' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    public function puzzles()
    {
        return $this->hasMany(Puzzle::class, 'category_id');
    }

    public function activePuzzles()
    {
        return $this->hasMany(Puzzle::class, 'category_id')->where('is_active', true);
    }

    public function getPuzzleCountAttribute()
    {
        return $this->puzzles()->where('is_active', true)->count();
    }

    public function getIconHtmlAttribute()
    {
        if ($this->icon) {
            return "<i class='{$this->icon}' style='color: {$this->color}'></i>";
        }
        return null;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('display_order');
    }
}