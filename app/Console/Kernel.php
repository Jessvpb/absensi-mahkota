<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Daftar Artisan commands yang tersedia.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\ResetIzinCommand::class,
        \App\Console\Commands\ResetCutiCommand::class,
    ];

    /**
     * Definisikan schedule aplikasi.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Reset izin tiap awal bulan (jam 00:00 tanggal 1)
        $schedule->command('reset:izin')->monthlyOn(1, '00:00');

        // Reset cuti tiap awal tahun (jam 00:00 tanggal 1 Januari)
        $schedule->command('reset:cuti')->yearlyOn(1, 1, '00:00');
    }

    /**
     * Register commands untuk aplikasi.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
