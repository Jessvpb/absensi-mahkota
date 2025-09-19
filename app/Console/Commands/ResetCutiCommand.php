<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Staff;

class ResetCutiCommand extends Command
{
    /**
     * Nama dan signature command.
     */
    protected $signature = 'reset:cuti';

    /**
     * Deskripsi command.
     */
    protected $description = 'Reset jatah cuti tahunan semua staff ke 10 hari';

    /**
     * Jalankan command.
     */
    public function handle()
    {
        Staff::query()->update(['cuti_tahunan' => 10]);

        $this->info('Jatah cuti tahunan berhasil direset ke 10 hari untuk semua staff.');
    }
}
