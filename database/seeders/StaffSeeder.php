<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class StaffSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('staff')->insert([
            // admin
            [
                'NIP' => 'MG070102-999',
                'nama' => 'Jessica Valencia',
                'JK' => 'P',
                'TTL' => '2004-08-29',
                'notel' => '081312233445',
                'alamat' => 'Jl. Rajawali Palembang',
                'tgl_masuk' => '2020-05-01',
                'tgl_keluar' => null,
                'gaji_pokok' => 12000000,
                'gaji_tunjangan' => 1500000,
                'absen_id'=>'100',
                'users_id'=>1,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now
            ]
        ]);
    }
}
