<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPengajuanDispensasi extends Model
{
    protected $table = 'detail_pengajuan_dispensasi';
    protected $fillable = [
        'pengajuan_dispensasi_id','tanggal','status','keterangan'
    ];
    // 1 header pengajuan memiliki banyak detail, 1 detail cuma punya 1 header
    public function pengajuan_dispensasi()
    {
        return $this->belongsTo(PengajuanDispensasi::class, 'pengajuan_dispensasi_id', 'id');
    }
}
