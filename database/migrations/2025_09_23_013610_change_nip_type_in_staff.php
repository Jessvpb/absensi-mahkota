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
        Schema::table('staff', function (Blueprint $table) {
            // Ubah absen_id dari unsignedBigInteger -> CHAR(3)
            $table->char('absen_id', 3)->nullable()->unique()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('staff', function (Blueprint $table) {
            // Kembalikan ke unsignedBigInteger
            $table->unsignedBigInteger('absen_id')->nullable()->unique()->change();
        });
    }
};
