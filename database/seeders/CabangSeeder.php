<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;


class CabangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cabang')->insert([
            [
                'nama_cabang' => 'Mahkota Gallery Dempo',
                'alamat' => 'Samping, Sekolah IPEKA, Jl. Dempo Luar No.968, 15 Ilir, Kec. Ilir Tim. I, Kota Palembang, Sumatera Selatan 30111',
                'jam_masuk' => '08:00:00',
                'jam_pulang' => '17:30:00',
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
