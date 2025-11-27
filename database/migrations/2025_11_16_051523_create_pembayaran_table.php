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
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftar_id')->constrained('pendaftar')->onDelete('cascade');
            $table->decimal('jumlah', 15, 2);
            $table->string('bukti_bayar')->nullable();
            $table->enum('status', ['BELUM_BAYAR', 'MENUNGGU_VERIFIKASI', 'TERBAYAR', 'DITOLAK'])->default('BELUM_BAYAR');
            $table->text('catatan')->nullable();
            $table->foreignId('verifikator_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('tanggal_upload')->nullable();
            $table->timestamp('tanggal_verifikasi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
