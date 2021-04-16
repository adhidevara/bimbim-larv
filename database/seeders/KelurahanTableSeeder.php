<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class KelurahanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tb_kelurahan')->delete();
        $kecamatan = DB::table('tb_kecamatan')->select('id_kecamatan')->get();

        foreach ($kecamatan as $kcm) {
            $response = Http::get('https://dev.farizdotid.com/api/daerahindonesia/kelurahan?id_kecamatan='.$kcm->id_kecamatan)['kelurahan'];
            foreach ($response as $kelurahan){
                DB::table('tb_kelurahan')->insert([
                    "id_kelurahan" => $kelurahan['id'],
                    "id_kecamatan" => $kelurahan['id_kecamatan'],
                    "nama" => $kelurahan['nama'],
                ]);
            }
        }
    }
}
