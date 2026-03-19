<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class JobOpportunity extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'summary',
        'description',
        'company',
        'company_logo',
        'location',
        'city',
        'country',
        'job_type',
        'category',
        'category_color',
        'experience_level',
        'salary_range',
        'badge_type',
        'badge_color',
        'posted_date',
        'application_deadline',
        'application_url',
        'requirements',
        'benefits',
        'is_featured',
        'is_published'
    ];

    protected $casts = [
        'posted_date' => 'date',
        'application_deadline' => 'date',
        'is_featured' => 'boolean',
        'is_published' => 'boolean'
    ];

    public function getFormattedPostedDateAttribute()
    {
        $days = Carbon::parse($this->posted_date)->diffInDays(now());
        
        if ($days == 0) return 'Posted today';
        if ($days == 1) return 'Posted 1 day ago';
        if ($days < 7) return "Posted {$days} days ago";
        if ($days < 30) return "Posted " . floor($days/7) . " weeks ago";
        return "Posted " . floor($days/30) . " months ago";
    }

    public function getPostedDaysAttribute()
    {
        return Carbon::parse($this->posted_date)->diffInDays(now());
    }

    public function getBadgeColorClassAttribute()
    {
        $colors = [
            'green' => 'bg-green-100 text-green-700',
            'orange' => 'bg-orange-100 text-orange-700'
        ];
        return $colors[$this->badge_color] ?? 'bg-green-100 text-green-700';
    }

    public function getCategoryColorClassAttribute()
    {
        $colors = [
            'indigo' => 'bg-indigo-100 text-indigo-700',
            'purple' => 'bg-purple-100 text-purple-700',
            'blue' => 'bg-blue-100 text-blue-700',
            'green' => 'bg-green-100 text-green-700'
        ];
        return $colors[$this->category_color] ?? 'bg-indigo-100 text-indigo-700';
    }
}