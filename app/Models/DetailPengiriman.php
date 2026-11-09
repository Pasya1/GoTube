<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPengiriman extends Model
{
    protected $table = 'detail_pengirimans';
    protected $fillable = ['pengiriman_id', 'kode_tabung'];

    public function pengiriman()
    {
        return $this->belongsTo(Pengiriman::class);
    }

    public function tabung()
    {
        return $this->belongsTo(Tabung::class, 'tabung_id');
    }
}
