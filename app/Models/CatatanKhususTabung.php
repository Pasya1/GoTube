<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CatatanKhususTabung extends Model
{
    protected $table = 'catatan_khusus_tabungs';

    protected $fillable = [
        'kode_tabung',
        'outlet_id',
        'user_id',
        'catatan',
    ];

    public function outlet(): BelongsTo
    {
        return $this->belongsTo(Outlet::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
