<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pendaftar_data_siswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftar_id')->constrained('pendaftar')->onDelete('cascade');
            $table->string('nik', 20);
            $table->string('nama_lengkap', 120);
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('tempat_lahir', 60);
            $table->date('tanggal_lahir');
            $table->text('alamat');
            $table->string('provinsi', 100);
            $table->string('kabupaten', 100);
            $table->string('kecamatan', 100);
            $table->string('kelurahan', 100)->nullable();
            $table->string('kodepos', 10)->nullable();
            $table->string('no_telepon', 20);
            $table->decimal('lat', 10, 7)->nullable();
            $table->decimal('lng', 10, 7)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pendaftar_data_siswa');
    }
};