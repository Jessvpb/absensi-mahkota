<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPengajuanIzin extends Model
{
    protected $table = 'detail_pengajuan_izin';
    protected $fillable = [
        'pengajuan_izin_id','tanggal','status','keterangan', 'pengganti'
    ];

    // 1 detail punya 1 header pengajuan
    public function pengajuan_izin()
    {
        return $this->belongsTo(PengajuanIzin::class, 'pengajuan_izin_id', 'id');
    }

    // Tambahkan relasi langsung ke staff melalui pengajuan_izin
    public function staff()
    {
        return $this->hasOneThrough(
            \App\Models\Staff::class,         // model tujuan
            \App\Models\PengajuanIzin::class, // model perantara
            'id',                              // foreign key di PengajuanIzin (local key di DetailPengajuanIzin = pengajuan_izin_id)
            'id',                              // foreign key di Staff (local key di PengajuanIzin = staff_id)
            'pengajuan_izin_id',               // local key di DetailPengajuanIzin
            'staff_id'                         // local key di PengajuanIzin
        );
    }
}
