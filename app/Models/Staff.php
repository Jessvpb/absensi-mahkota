<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $table = 'staff';
    protected $fillable = [
        'NIP',
        'nama',
        'JK',
        'TTL',
        'notel',
        'alamat',
        'tgl_masuk',
        'tgl_keluar',
        'gaji_pokok',
        'gaji_tunjangan',
        'absen_id',
        'users_id',
        'is_active',
    ];
    public function users()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }
    // 1 staff bisa kerja di banyak cabang | 1 cabang bisa memiliki banyak staff
    public function cabang()
    {
        return $this->belongsToMany(Cabang::class, 'staff_cabang', 'staff_id', 'cabang_id')->withTimestamps();
    }
    public function jabatan()
    {
        return $this->belongsToMany(Jabatan::class, 'staff_jabatan', 'staff_id', 'jabatan_id')->withTimestamps();
    }

    // Semua pengajuan izin yang dia ajukan
    public function pengajuanIzin()
    {
        return $this->hasMany(PengajuanIzin::class, 'staff_id', 'id');
    }

    // Semua pengajuan izin yang dia validasi sebagai admin
    public function pengajuanIzinDivalidasi()
    {
        return $this->hasMany(PengajuanIzin::class, 'admin_id', 'id');
    }

    // Semua pengajuan kronologi yang dia ajukan
    public function pengajuanKronologi()
    {
        return $this->hasMany(PengajuanKronologi::class, 'staff_id', 'id');
    }

    // Semua pengajuan kronologi yang dia validasi sebagai kepala cabang
    public function pengajuanKronologiDivalidasiKepala()
    {
        return $this->hasMany(PengajuanKronologi::class, 'kepala_id', 'id');
    }

    // Semua pengajuan kronologi yang dia validasi sebagai admin
    public function pengajuanKronologiDivalidasiAdmin()
    {
        return $this->hasMany(PengajuanKronologi::class, 'admin_id', 'id');
    }

    public function cabangAktif()
    {
        return $this->hasOne(StaffCabang::class)->where('is_active', true);
    }

    public function staffCabang()
    {
        return $this->hasMany(StaffCabang::class);
    }

    public function absen()
    {
        return $this->hasMany(Absen::class);
    }
}
