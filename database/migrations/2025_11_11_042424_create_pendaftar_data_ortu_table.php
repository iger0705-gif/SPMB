<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pendaftar_data_ortu', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftar_id')->constrained('pendaftar')->onDelete('cascade');
            $table->string('nama_ayah', 120);
            $table->string('pekerjaan_ayah', 100)->nullable();
            $table->string('hp_ayah', 20)->nullable();
            $table->string('nama_ibu', 120);
            $table->string('pekerjaan_ibu', 100)->nullable();
            $table->string('hp_ibu', 20)->nullable();
            $table->string('wali_nama', 120)->nullable();
            $table->string('wali_hp', 20)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pendaftar_data_ortu');
    }
};