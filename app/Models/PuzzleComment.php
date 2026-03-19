<?php
// app/Models/PuzzleComment.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PuzzleComment extends Model
{
    use HasFactory;

    protected $table = 'puzzle_comments';

    protected $fillable = [
        'puzzle_id',
        'donor_id',
        'parent_id',
        'comment',
        'likes',
        'is_approved',
        'is_edited',
        'metadata',
    ];

    protected $casts = [
        'likes' => 'integer',
        'is_approved' => 'boolean',
        'is_edited' => 'boolean',
        'metadata' => 'array',
    ];

    public function puzzle()
    {
        return $this->belongsTo(Puzzle::class);
    }

    public function donor()
    {
        return $this->belongsTo(Donor::class);
    }

    public function parent()
    {
        return $this->belongsTo(PuzzleComment::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(PuzzleComment::class, 'parent_id');
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }
}