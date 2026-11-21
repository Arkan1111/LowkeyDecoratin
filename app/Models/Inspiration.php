<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inspiration extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'package_id',
        'title',
        'slug',
        'venue_type',
        'guest_capacity',
        'image_path',
        'description',
        'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }
}