<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftar_id')->constrained('pendaftar')->onDelete('cascade');
            $table->string('no_pembayaran')->unique();
            $table->decimal('jumlah', 10, 2);
            $table->enum('jenis_pembayaran', ['pendaftaran', 'daftar_ulang']);
            $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->string('bukti_pembayaran')->nullable();
            $table->timestamp('tanggal_bayar')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
