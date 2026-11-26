<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'type',
        'name',
        'slug',
        'tagline',
        'description',
        'price',
        'normal_price',
        'features',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'features' => 'array',
            'price' => 'decimal:2',
            'normal_price' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(PackageImage::class);
    }

    public function reservationDetails(): HasMany
    {
        return $this->hasMany(ReservationDetail::class);
    }

    public function inspirations(): HasMany
    {
        return $this->hasMany(Inspiration::class);
    }
}