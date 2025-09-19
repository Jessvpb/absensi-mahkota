<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    use HasFactory;

    protected $table = 'absen';

    protected $fillable = [
        'staff_id',
        'cabang_id',
        'tanggal',
        'status',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    // Relasi ke staff
    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    // Relasi ke cabang
    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }

    // Format status menjadi label jika ingin dipakai di view
    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'H' => 'Hadir',
            'T' => 'Telat',
            'A' => 'Alpa',
            'I' => 'Izin',
            'S' => 'Sakit',
            'O' => 'Off',
            'C' => 'Cuti',
            'D' => 'Dispensasi',
            default => '-',
        };
    }
}
