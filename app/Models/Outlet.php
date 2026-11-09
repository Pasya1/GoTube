<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    protected $table = 'outlet';

    protected $fillable = [
        'nama_outlet',
        'nama_spv',
        'nama_area',
        'merk_inflator',
        'merk_regulator',
        'distribusi_by',
        'nama_vendor',
        'harga_isi_n2',
        'latitude',
        'longitude',
    ];

    public function sales()
    {
        return $this->hasMany(Sale::class, 'outlet_id');
    }
}
