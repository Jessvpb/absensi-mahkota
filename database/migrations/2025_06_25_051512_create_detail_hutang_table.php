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
        Schema::create('detail_hutang', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hutang_id');
            $table->foreign('hutang_id')->references('id')->on('hutang');
            $table->decimal('jumlah_hutang', 12, 2);
            $table->date('tanggal_pelunasan');//bulan-tahun
            $table->boolean('status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_hutang');
    }
};
