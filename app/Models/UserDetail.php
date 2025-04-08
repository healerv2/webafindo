<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserDetail extends Model
{
    //
    protected $table = 'user_details';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class)->withDefault([
            'nama_area' => 'Data belum lengkap'
        ]);
    }

    public function paket()
    {
        return $this->belongsTo(DataPaket::class)->withDefault([
            'nama_paket' => 'Data belum lengkap'
        ]);
    }

    public function mikrotik()
    {
        return $this->belongsTo(Mikrotik::class)->withDefault([
            'name' => 'Data belum lengkap'
        ]);
    }
}
