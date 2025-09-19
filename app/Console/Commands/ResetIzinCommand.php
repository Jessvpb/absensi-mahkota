<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Staff;

class ResetIzinCommand extends Command
{
    /**
     * Nama dan signature command.
     */
    protected $signature = 'reset:izin';

    /**
     * Deskripsi command.
     */
    protected $description = 'Reset jatah izin bulanan semua staff ke 3 hari';

    /**
     * Jalankan command.
     */
    public function handle()
    {
        Staff::query()->update(['izin_bulanan' => 3]);

        $this->info('Jatah izin bulanan berhasil direset ke 3 hari untuk semua staff.');
    }
}
