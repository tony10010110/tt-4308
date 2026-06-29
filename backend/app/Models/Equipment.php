<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Equipment extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'description',
        'category',
        'price_per_day',
        'is_available',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_available'  => 'boolean',
        'is_active'     => 'boolean',
        'price_per_day' => 'decimal:2',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('photo')->singleFile();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
