<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'category',
        'type',
        'location',
        'start_date',
        'end_date',
        'timezone',
        'organizer',
        'venue',
        'city',
        'country',
        'capacity',
        'price',
        'is_free_for_members',
        'registration_url',
        'featured_image',
        'badge_type',
        'badge_color',
        'is_featured',
        'is_published'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_free_for_members' => 'boolean',
        'is_featured' => 'boolean',
        'is_published' => 'boolean'
    ];

    public function getFormattedStartDateAttribute()
    {
        return Carbon::parse($this->start_date)->format('d M');
    }

    public function getFormattedStartDateTimeAttribute()
    {
        return Carbon::parse($this->start_date)->format('F j, Y • g:i A');
    }

    public function getFormattedEndDateTimeAttribute()
    {
        return Carbon::parse($this->end_date)->format('g:i A T');
    }

    public function getBadgeColorClassAttribute()
    {
        $colors = [
            'green' => 'bg-green-100 text-green-700',
            'yellow' => 'bg-yellow-100 text-yellow-700',
            'blue' => 'bg-blue-100 text-blue-700'
        ];
        return $colors[$this->badge_color] ?? 'bg-green-100 text-green-700';
    }
}