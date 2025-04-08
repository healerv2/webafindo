<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DataPaket;

class PaketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $paket = DataPaket::create([
            'nama_paket'       => 'Paket 1',
            'harga_paket'     => '100000',
        ]);
    }
}
