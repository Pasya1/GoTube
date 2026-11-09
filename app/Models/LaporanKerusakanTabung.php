<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanKerusakanTabung extends Model
{
    protected $fillable = [
        'pengiriman_id',
        'tabung_id',
        'catatan',
        'status',
        'user_id'
    ];

    public function pengiriman()
    {
        return $this->belongsTo(Pengiriman::class);
    }

    public function tabung()
    {
        return $this->belongsTo(Tabung::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
