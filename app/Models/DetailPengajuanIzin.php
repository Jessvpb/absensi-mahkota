<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPengajuanIzin extends Model
{
    protected $table = 'detail_pengajuan_izin';
    protected $fillable = [
        'pengajuan_izin_id','tanggal','status','keterangan', 'pengganti'
    ];
    // 1 header pengajuan memiliki banyak detail, 1 detail cuma punya 1 header
    public function pengajuan_izin()
    {
        return $this->belongsTo(PengajuanIzin::class, 'pengajuan_izin_id', 'id');
    }
}
