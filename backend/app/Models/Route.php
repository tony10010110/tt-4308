<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Route extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'short_description',
        'difficulty',
        'duration_days',
        'price',
        'location',
        'max_participants',
        'included',
        'excluded',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'included'    => 'array',
        'excluded'    => 'array',
        'is_active'   => 'boolean',
        'price'       => 'decimal:2',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cover')->singleFile();
        $this->addMediaCollection('gallery');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
