<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPN extends Model
{
    //
    protected $table = 'ppns';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
}
