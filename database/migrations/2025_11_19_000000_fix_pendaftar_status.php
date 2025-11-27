<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Update status pendaftar yang belum upload dokumen ke DRAFT
        DB::statement("
            UPDATE pendaftar 
            SET status = 'DRAFT' 
            WHERE status = 'SUBMIT' 
            AND id NOT IN (
                SELECT DISTINCT pendaftar_id 
                FROM documents 
                WHERE pendaftar_id IS NOT NULL
            )
        ");
    }

    public function down()
    {
        // Rollback tidak diperlukan
    }
};