<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('financial_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_id')->nullable()->constrained('payments')->nullOnDelete();
            $table->enum('type', ['pemasukan', 'pengeluaran']);
            $table->string('category'); // e.g. "Pembayaran DP", "Pelunasan", "Pembelian Bunga", "Transport"
            $table->decimal('amount', 12, 2);
            $table->decimal('balance_after', 12, 2)->default(0); // Saldo kumulatif setelah transaksi
            $table->text('description')->nullable();
            $table->date('transaction_date');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('financial_transactions');
    }
};