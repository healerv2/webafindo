<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TugasTeknisi extends Model
{
    //
    protected $table = 'tugas_teknisi';
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

    public function teknisi()
    {
        return $this->hasOne(User::class, 'id', 'teknisi');
    }
}
