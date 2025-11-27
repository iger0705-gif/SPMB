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
        Schema::table('pendaftar_data_siswa', function (Blueprint $table) {
            $table->string('nisn', 20)->nullable()->after('nik');
            $table->string('agama', 20)->nullable()->after('tanggal_lahir');
            $table->string('no_hp', 20)->nullable()->after('no_telepon');
            $table->string('email', 100)->nullable()->after('no_hp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftar_data_siswa', function (Blueprint $table) {
            $table->dropColumn(['nisn', 'agama', 'no_hp', 'email']);
        });
    }
};
