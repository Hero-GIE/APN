<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilteredImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'original_image',
        'filtered_image',
        'filter_type',
        'status'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(Donor::class, 'user_id');
    }

    public function getFilteredImageUrlAttribute()
    {
        return asset('storage/' . $this->filtered_image);
    }

    public function getOriginalImageUrlAttribute()
    {
        return asset('storage/' . $this->original_image);
    }
}