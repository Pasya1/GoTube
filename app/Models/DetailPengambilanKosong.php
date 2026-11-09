<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPengambilanKosong extends Model
{
    protected $table = 'detail_pengambilan_kosong';
    protected $fillable = ['pengiriman_id', 'kode_tabung'];

    public function pengiriman()
    {
        return $this->belongsTo(Pengiriman::class);
    }
}
