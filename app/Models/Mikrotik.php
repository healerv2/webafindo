<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mikrotik extends Model
{
    //
    protected $table = 'mikrotiks';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // protected $hidden = [
    //     'password',
    // ];

    public function loginLogs()
    {
        return $this->hasMany(LoginLog::class);
    }
}
