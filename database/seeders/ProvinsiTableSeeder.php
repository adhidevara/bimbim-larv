<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ProvinsiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tb_provinsi')->delete();
        $response = Http::get('https://dev.farizdotid.com/api/daerahindonesia/provinsi')['provinsi'];

        foreach ($response as $prov){
            DB::table('tb_provinsi')->insert([
                "id_provinsi" => $prov['id'],
                "nama" => $prov['nama'],
            ]);
        }
    }
}
