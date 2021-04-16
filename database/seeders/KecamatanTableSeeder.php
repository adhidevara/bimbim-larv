<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class KecamatanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tb_kecamatan')->delete();
        $kota = DB::table('tb_kota')->select('id_kota')->get();

        foreach ($kota as $kta) {
            $response = Http::get('https://dev.farizdotid.com/api/daerahindonesia/kecamatan?id_kota='.$kta->id_kota)['kecamatan'];
            foreach ($response as $kecamatan){
                DB::table('tb_kecamatan')->insert([
                    "id_kecamatan" => $kecamatan['id'],
                    "id_kota" => $kecamatan['id_kota'],
                    "nama" => $kecamatan['nama'],
                ]);
            }
        }
    }
}
