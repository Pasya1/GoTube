<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengiriman extends Model
{
    protected $table = 'pengirimans';
    protected $fillable = ['outlet_id', 'tanggal_pengiriman', 'keterangan', 'status', 'keterangan_pengambilan'];
    protected $casts = [
        'tanggal_pengiriman' => 'date',
    ];

    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }

    public function details()
    {
        return $this->hasMany(DetailPengiriman::class);
    }
    public function tabungs()
    {
        return $this->hasMany(DetailPengiriman::class, 'pengiriman_id');
    }
    public function pengambilanKosong()
    {
        return $this->hasMany(DetailPengambilanKosong::class, 'pengiriman_id');
    }
    public function laporanKerusakan()
    {
        return $this->hasMany(LaporanKerusakanTabung::class);
    }
}
