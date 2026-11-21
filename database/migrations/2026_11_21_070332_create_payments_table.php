<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_id')->constrained('reservations')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->enum('payment_type', ['dp', 'pelunasan']);
            $table->decimal('amount', 12, 2);
            $table->string('bank_name')->nullable(); // e.g. "BCA", "Mandiri"
            $table->string('sender_name')->nullable();
            $table->string('proof_image');
            $table->enum('status', ['menunggu_verifikasi', 'valid', 'ditolak'])->default('menunggu_verifikasi');
            $table->text('rejection_reason')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};