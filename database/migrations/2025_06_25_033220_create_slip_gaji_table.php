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
        Schema::create('slip_gaji', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('staff_id');
            $table->foreign('staff_id')->references('id')->on('staff')->onDelete('cascade');
            $table->unsignedBigInteger('cabang_id')->nullable();
            $table->foreign('cabang_id')->references('id')->on('cabang')->onDelete('set null');

            $table->date('periode'); // contoh: 2025-06-01 (kerja bulan Juni)
            $table->date('tanggal_penggajian');

            $table->decimal('gaji_pokok', 12, 2);
            $table->decimal('gaji_tunjangan', 12, 2);

            $table->decimal('potongan_terlambat', 12, 2)->default(0);
            $table->decimal('potongan_alpha', 12, 2)->default(0);
            $table->decimal('potongan_izin', 12, 2)->default(0);
            $table->decimal('potongan_kronologi', 12, 2)->default(0);
            $table->decimal('potongan_hutang', 12, 2)->default(0);

            $table->decimal('gaji_bersih', 12, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slip_gaji');
    }
};
