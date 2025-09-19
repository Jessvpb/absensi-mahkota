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
        Schema::create('kronologi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('staff_id');
            $table->foreign('staff_id')->references('id')->on('staff');

            $table->unsignedBigInteger('cabang_id')->nullable();
            $table->foreign('cabang_id')->references('id')->on('cabang');

            $table->string('judul');
            $table->string('nama_barang');
            $table->string('penjelasan');
            $table->decimal('harga_barang', 12, 2);
            $table->integer('periode_pelunasan'); // bulan
            $table->string('keterangan')->nullable();

            $table->boolean('validasi_kepalacabang')->nullable();
            $table->unsignedBigInteger('kepala_id')->nullable();
            $table->foreign('kepala_id')->references('id')->on('staff');

            $table->boolean('validasi_admin')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->foreign('admin_id')->references('id')->on('staff');

            $table->text('alasan_kepalacabang')->nullable();
            $table->text('alasan_admin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kronologi');
    }
};
