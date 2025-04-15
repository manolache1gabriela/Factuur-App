<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('clients')->insert([
            [
            'name' => 'Calamintha',
            'btw_number' => '748.909.383',
            'add_btw' => true,
            'address' => 'Eigenaarsstraat 20 bus 2, 2380 Ravels'
            ],
            [
            'name' => 'P&O Rombouts',
            'btw_number' => '715.794.870',
            'add_btw' => true,
            'address' => 'Papenvelden 16, 2370 Arendonk'
            ],
            [
            'name' => 'TEfunderen',
            'btw_number' => '1.015.821.216',
            'add_btw' => true,
            'address' => 'Eikenlaan 19, 3110 Rotselaar'
            ],
            [
            'name' => 'Patricia Perez & Pablo Romojaro',
            'btw_number' => '',
            'add_btw' => false,
            'address' => 'Koekoekstraat 105,  Mol'
            ]
        ]);
    }
}