<?php
// app/Models/Magazine.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Magazine extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'file_path',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getTypeIconAttribute()
    {
        return match($this->type) {
            'magazine' => 'fas fa-book-open',
            'report' => 'fas fa-chart-bar',
            'newsletter' => 'fas fa-envelope-open-text',
            default => 'fas fa-file-pdf',
        };
    }

    public function getTypeColorAttribute()
    {
        return match($this->type) {
            'magazine' => 'text-purple-600',
            'report' => 'text-blue-600',
            'newsletter' => 'text-green-600',
            default => 'text-gray-600',
        };
    }
}