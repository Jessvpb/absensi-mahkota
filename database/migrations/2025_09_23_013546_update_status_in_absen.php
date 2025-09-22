<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tambahkan enum 'E' dan 'L'
        DB::statement("ALTER TABLE absen 
            MODIFY status ENUM('A', 'H', 'I', 'S', 'O', 'C', 'T', 'D', 'E', 'L') 
            NOT NULL DEFAULT 'H'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan ke enum lama (tanpa 'E' dan 'L')
        DB::statement("ALTER TABLE absen 
            MODIFY status ENUM('A', 'H', 'I', 'S', 'O', 'C', 'T', 'D') 
            NOT NULL DEFAULT 'H'");
    }
};
