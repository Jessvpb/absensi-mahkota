<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('pengajuan_izin', function (Blueprint $table) {
            // Menambahkan kolom untuk mencatat waktu persetujuan masing-masing
            $table->timestamp('tgl_validasi_kepala')->nullable()->after('validasi_kepalacabang');
            $table->timestamp('tgl_validasi_admin')->nullable()->after('validasi_admin');
        });
    }

    public function down()
    {
        Schema::table('pengajuan_izin', function (Blueprint $table) {
            $table->dropColumn(['tgl_validasi_kepala', 'tgl_validasi_admin']);
        });
    }
};
