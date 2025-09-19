<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanKronologi extends Model
{
    protected $table = 'kronologi';
    protected $fillable = [
        'staff_id',
        'cabang_id',
        'judul',
        'nama_barang',
        'penjelasan',
        'harga_barang',
        'keterangan',
        'validasi_kepalacabang',
        'kepala_id',
        'validasi_admin',
        'admin_id',
        'periode_pelunasan',
    ];

    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'cabang_id', 'id');
    }

    // Relasi ke staff (yang mengajukan)
    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id', 'id');
    }

    // Relasi ke kepala (yang memvalidasi)
    public function kepala()
    {
        return $this->belongsTo(Staff::class, 'kepala_id', 'id');
    }

    // Relasi ke admin (yang memvalidasi)
    public function admin()
    {
        return $this->belongsTo(Staff::class, 'admin_id', 'id');
    }
}
