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
                'name' => 'IPW',
                'btw_number' => '1023.553.007',
                'has_btw' => true,
                'address' => 'Hofstraat 17, 2480 Dessel',
                'deleted' => false
            ]
        ]);
    }
}
