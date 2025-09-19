<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanIzin extends Model
{
    protected $table = 'pengajuan_izin';
    protected $fillable = [
        'staff_id',
        'cabang_id',
        'validasi_admin',
        'admin_id',
        'validasi_kepalacabang',
        'kepala_id',
    ];
    // 1 pengajuan punya 1 karyawan | 1 karyawan punya banyak pengajuan
    // Relasi ke staff (yang mengajukan)
    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'cabang_id', 'id');
    }
    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id', 'id');
    }

    // Relasi ke kepala (yang memvalidasi)
    public function kepala()
    {
        return $this->belongsTo(Staff::class, 'kepala_id', 'id');
    }

    // 1 pengajuan punya 1 admin yg validasi | 1 admin bisa validasi banyak pengajuan
    // Relasi ke admin (yang memvalidasi)
    public function admin()
    {
        return $this->belongsTo(Staff::class, 'admin_id', 'id');
    }

    public function detail_pengajuan_izin()
    {
        return $this->hasMany(DetailPengajuanIzin::class, 'pengajuan_izin_id', 'id');
    }
}
