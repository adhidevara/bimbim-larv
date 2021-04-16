<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MapelUnggulanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tb_mapel_unggulan')->delete();

        $allData = [
            [3, 'Matematika'],
            [3, 'IPA'],
            [3, 'BhsIndonesia'],
            [4, 'Matematika'],
            [4, 'IPS'],
            [4, 'BhsInggris'],
            [5, 'PKN'],
            [5, 'Kimia'],
            [5, 'Biologi'],
        ];
        foreach ($allData as $dat){
            DB::table('tb_mapel_unggulan')->insert([
                'id_mitra'  => $dat[0],
                'nama_mapel'=> $dat[1],
            ]);
        }
    }
}
