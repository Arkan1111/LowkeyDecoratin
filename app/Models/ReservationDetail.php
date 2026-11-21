<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReservationDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_id',
        'package_id',
        'price',
        'quantity',
        'subtotal',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'subtotal' => 'decimal:2',
            'quantity' => 'integer',
        ];
    }

    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }
}