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
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->char('NIP',12)->unique();
            $table->string('nama');
            $table->enum('JK', ['L', 'P']);
            $table->date('TTL');
            $table->string('notel');
            $table->string('alamat');
            $table->date('tgl_masuk');
            $table->date('tgl_keluar')->nullable();
            $table->decimal('gaji_pokok', 12, 2);
            $table->decimal('gaji_tunjangan', 12, 2);

            $table->string('absen_id')->nullable()->unique();

            $table->unsignedBigInteger('users_id')->nullable()->unique();
            $table->foreign('users_id')->references('id')->on('users');
            $table->boolean('is_active')->default(true);

            // Tambahan kolom untuk jatah izin & cuti
            $table->integer('izin_bulanan')->default(3);
            $table->integer('cuti_tahunan')->default(10);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
