<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'category',
        'category_color',
        'featured_image',
        'author',
        'published_date',
        'is_featured',
        'is_published'
    ];

    protected $casts = [
        'published_date' => 'date',
        'is_featured' => 'boolean',
        'is_published' => 'boolean'
    ];

    public function getFormattedDateAttribute()
    {
        return Carbon::parse($this->published_date)->format('F j, Y');
    }

    public function getCategoryColorClassAttribute()
    {
        $colors = [
            'indigo' => 'text-indigo-600',
            'green' => 'text-green-600',
            'blue' => 'text-blue-600',
            'purple' => 'text-purple-600'
        ];
        return $colors[$this->category_color] ?? 'text-indigo-600';
    }
}