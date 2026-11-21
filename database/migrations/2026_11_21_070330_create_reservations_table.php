<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('reservation_code')->unique(); // e.g. "LOKI-20261121-001"
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->date('event_date');
            $table->time('event_time')->nullable();
            $table->string('venue_name')->nullable();
            $table->text('venue_address');
            $table->text('concept_notes')->nullable();
            $table->decimal('total_amount', 12, 2)->default(0);
            $table->enum('status', [
                'menunggu',
                'diterima',
                'dp_dibayar',
                'lunas',
                'pengerjaan',
                'selesai',
                'dibatalkan'
            ])->default('menunggu');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};