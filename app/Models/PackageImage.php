<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PackageImage extends Model
{
    use HasFactory;

    protected $fillable = ['package_id', 'image_path', 'is_primary'];

    protected function casts(): array
    {
        return [
            'is_primary' => 'boolean',
        ];
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }
}