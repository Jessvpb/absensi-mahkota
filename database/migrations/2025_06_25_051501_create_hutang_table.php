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
        Schema::create('hutang', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('staff_id');
            $table->foreign('staff_id')->references('id')->on('staff');

            $table->decimal('jumlah_hutang', 12, 2);
            $table->integer('periode_pelunasan'); // bulan

            $table->date('start_pelunasan');//bulan-tahun

            $table->decimal('sisa_hutang', 12, 2)->nullable();
            $table->enum('status', ['ONGOING', 'LUNAS', 'BATAL'])->default('ONGOING');

            $table->enum('jenis',['izin','kronologi','pinjam']);

            // kalo type kronologi maka akan terisi kolom ini yg nunjukin kronologi yg mana
            $table->unsignedBigInteger('kronologi_id')->nullable();
            $table->foreign('kronologi_id')->references('id')->on('kronologi');

            // kalo type pinjaman maka akan terisi kolom ini yg nunjukin pinjaman yg mana
            $table->unsignedBigInteger('pinjaman_id')->nullable();
            $table->foreign('pinjaman_id')->references('id')->on('pengajuan_pinjaman');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hutang');
    }
};
