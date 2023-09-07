<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('items')->truncate();
        DB::table('items')->insert([
            'title' => 'Komputer',
            'details' => 'Komputer Riba Jenama Lenovo',
            'user_id' => 1
        ]);
        DB::table('items')->insert([
            'title' => 'Meja',
            'details' => 'Meja Di Bilik A',
            'user_id' => 1
        ]);
        DB::table('items')->insert([
            'title' => 'Kerusi',
            'details' => 'Kerusi Di Dewan Serbaguna',
            'user_id' => 2
        ]);
    }
}
