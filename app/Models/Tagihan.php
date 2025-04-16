<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class Tagihan extends Model
{
    //
    protected $table = 'tagihans';
    protected $primaryKey = 'id';
    protected $guarded = [];
    // protected $fillable = [
    //     'user_id',
    //     'no_invoice',
    //     'paket',
    //     'tarif',
    //     'tanggal',
    //     'bulan',
    //     'tahun',
    //     'admin',
    //     'status',
    //     'note',
    //     'invoice_url'
    // ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function admin()
    {
        return $this->hasOne(User::class, 'id', 'admin');
    }

    public function getPeriodeAttribute()
    {
        $namaBulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        $bulan = $namaBulan[$this->bulan] ?? '';
        return $bulan . ' ' . $this->tahun;
    }

    // public function setTanggalAttribute($value)
    // {
    //     // Jika bulan dan tahun sudah diset langsung, gunakan untuk membuat tanggal
    //     if (isset($this->attributes['bulan']) && isset($this->attributes['tahun'])) {
    //         $this->attributes['tanggal'] = Carbon::createFromDate(
    //             $this->attributes['tahun'],
    //             $this->attributes['bulan'],
    //             1
    //         )->format('Y-m-d');
    //     } else {
    //         $this->attributes['tanggal'] = $value;
    //     }
    // }

    // public function scopeBulan($query, $bulan)
    // {
    //     return $query->where('bulan', $bulan);
    // }

    // public function scopeTahun($query, $tahun)
    // {
    //     return $query->where('tahun', $tahun);
    // }

    public function scopePeriode($query, $bulan, $tahun)
    {
        return $query->where('bulan', $bulan)->where('tahun', $tahun);
    }
}
