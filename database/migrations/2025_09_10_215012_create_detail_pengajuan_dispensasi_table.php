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
        Schema::create('detail_pengajuan_dispensasi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pengajuan_dispensasi_id');
            $table->foreign('pengajuan_dispensasi_id')->references('id')->on('pengajuan_dispensasi');
            $table->date('tanggal');
            $table->enum('status', ['I', 'S', 'O', 'C', 'D']);
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pengajuan_dispensasi');
    }
};
