<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BidangTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tb_bidangs')->delete();
        $allData = [
            [
                1,
                'BMG-1',
                'BIMGURU',
            ],
            [
                2,
                'BMP-2',
                'BIMPELATIH',
            ],
            [
                3,
                'BME-3',
                'BIMEVENT',
            ],
        ];
        foreach ($allData as $data) {
            DB::table('tb_bidangs')->insert([
                'id_bidang' => $data[0],
                'kode_bidang' => $data[1],
                'nama_bidang' => $data[2],
                'created_at' => now()
            ]);
        }
    }
}
