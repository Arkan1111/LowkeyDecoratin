<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('tagline')->nullable(); // e.g. "The Basic Intimate"
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2);
            $table->decimal('normal_price', 12, 2)->nullable();
            $table->json('features')->nullable(); // List fasilitas/keunggulan paket
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};