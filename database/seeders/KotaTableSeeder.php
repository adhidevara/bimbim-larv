<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class KotaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tb_kota')->delete();
        $provinsi = DB::table('tb_provinsi')->select('id_provinsi')->get();

        foreach ($provinsi as $prv) {
            $response = Http::get('https://dev.farizdotid.com/api/daerahindonesia/kota?id_provinsi='.$prv->id_provinsi)['kota_kabupaten'];
            foreach ($response as $kota){
                DB::table('tb_kota')->insert([
                    "id_kota" => $kota['id'],
                    "id_provinsi" => $kota['id_provinsi'],
                    "nama" => $kota['nama'],
                ]);
            }
        }
    }
}
