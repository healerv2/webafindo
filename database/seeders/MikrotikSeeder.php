<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Mikrotik;

class MikrotikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $paket = Mikrotik::create([
            'name'       => 'Test Mikrotik',
            'ip'     => '10.100.10.100',
            'port'     => '8728',
            'username'     => 'username',
            'password'     => 'password',
        ]);
    }
}
