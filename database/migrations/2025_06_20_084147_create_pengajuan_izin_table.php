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
        Schema::create('pengajuan_izin', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('staff_id');
            $table->foreign('staff_id')->references('id')->on('staff');

            $table->unsignedBigInteger('cabang_id')->nullable();
            $table->foreign('cabang_id')->references('id')->on('cabang');

            $table->text('alasan_kepalacabang')->nullable();
            $table->text('alasan_admin')->nullable();

            $table->boolean('validasi_kepalacabang')->nullable();
            $table->unsignedBigInteger('kepala_id')->nullable();
            $table->foreign('kepala_id')->references('id')->on('staff');
            
            $table->boolean('validasi_admin')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->foreign('admin_id')->references('id')->on('staff');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_izin');
    }
};
