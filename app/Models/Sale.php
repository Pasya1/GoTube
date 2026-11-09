<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sale extends Model
{
    protected $table = 'sales';

    protected $fillable = [
        'bulan',
        'date_in',
        'item',
        'tekanan',
        'no_tabung',
        'seri_tabung',
        'date_end',
        'sales_tabung',
        'keterangan',
        'catatan',
        'nama_operator',
        'outlet_id',
        'user_id',
    ];

    protected $casts = [
        'date_in' => 'date',
        'date_end' => 'date',
        'tekanan' => 'decimal:3',
        'sales_tabung' => 'decimal:2',
    ];

    public function outlet(): BelongsTo
    {
        return $this->belongsTo(
            Outlet::class,
            'outlet_id'
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }
}
