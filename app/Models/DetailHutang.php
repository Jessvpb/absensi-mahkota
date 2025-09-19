<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailHutang extends Model
{
    protected $table = 'detail_hutang';
    protected $fillable = [
        'hutang_id','jumlah_hutang','tanggal_pelunasan','status'
    ];
    public function hutang()
    {
        return $this->belongsTo(Hutang::class, 'hutang_id', 'id');
    }
}
