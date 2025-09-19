<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SlipGaji extends Model
{
    protected $table = 'slip_gaji';
    protected $fillable = [
        'staff_id',
        'cabang_id',
        'periode',
        'tanggal_penggajian',
        'gaji_pokok',
        'gaji_tunjangan',
        'potongan_izin',
        'potongan_alpha',
        'potongan_terlambat',
        'potongan_kronologi',
        'potongan_hutang',
        'gaji_bersih',

    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'cabang_id', 'id');
    }
}
