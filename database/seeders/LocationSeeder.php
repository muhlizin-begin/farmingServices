<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [
            ['nama_lokasi' => '520C1', 'status_lokasi' => 'NSFC', 'luas_lokasi' => 0],
            ['nama_lokasi' => '072D1', 'status_lokasi' => 'NSFC', 'luas_lokasi' => 0],
            ['nama_lokasi' => '520C2', 'status_lokasi' => 'NSFC', 'luas_lokasi' => 0],
            ['nama_lokasi' => '148D',  'status_lokasi' => 'NSFC', 'luas_lokasi' => 0],
            ['nama_lokasi' => '146F',  'status_lokasi' => 'NSSC', 'luas_lokasi' => 0],
        ];

        DB::table('locations')->insert($locations);
    }
}
