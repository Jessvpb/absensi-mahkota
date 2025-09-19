<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hutang extends Model
{
    protected $table = 'hutang';
    protected $fillable = [
        'staff_id','jumlah_hutang','periode_pelunasan','start_pelunasan',
        'status','jenis','kronologi_id','pinjaman_id'
    ];
    public function detail_hutang()
    {
        return $this->hasMany(DetailHutang::class, 'hutang_id', 'id');
    }
}
