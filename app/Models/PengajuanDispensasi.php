<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanDispensasi extends Model
{
    protected $table = 'pengajuan_dispensasi';
    protected $fillable = [
        'staff_id','validasi_admin','admin_id'
    ];
    // 1 pengajuan punya 1 karyawan | 1 karyawan punya banyak pengajuan
    // Relasi ke staff (yang mengajukan)
    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id', 'id');
    }

    // 1 pengajuan punya 1 admin yg validasi | 1 admin bisa validasi banyak pengajuan
    // Relasi ke admin (yang memvalidasi)
    public function admin()
    {
        return $this->belongsTo(Staff::class, 'admin_id', 'id');
    }

    public function detail_pengajuan_dispensasi()
    {
        return $this->hasMany(DetailPengajuanDispensasi::class, 'pengajuan_dispensasi_id', 'id');
    }
}
