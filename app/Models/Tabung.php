<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tabung extends Model
{
    protected $table = 'tabung';

    protected $fillable = [
        'kode_tabung',
        'nomor_seri',
        'catatan',
        'status'
    ];
    public function pengiriman()
    {
        return $this->hasMany(Pengiriman::class, 'tabung_id');
    }
    public function laporanKerusakan()
    {
        return $this->hasMany(LaporanKerusakanTabung::class);
    }
}
