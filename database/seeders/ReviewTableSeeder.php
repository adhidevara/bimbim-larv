<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReviewTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tb_reviews')->delete();

        $allData = [
            ['1','3','belajar seru banyak diskon cuma disini!','2',],
            ['2','2','seneng banget belajar bareng bimbim, dijamin seru!!!','3',],
            ['3','1','bareng kaka ini semua PR ku bisa selesai tepat waktu no worry Daring!','4',],
            ['4','3','belajar seru banyak diskon cuma disini!','3',],
            ['5','2','seneng banget belajar bareng bimbim, dijamin seru!!!','4',],
            ['6','1','bareng kaka ini semua PR ku bisa selesai tepat waktu no worry Daring!','2',],
            ['7','3','belajar seru banyak diskon cuma disini!','4',],
            ['8','2','seneng banget belajar bareng bimbim, dijamin seru!!!','2',],
            ['9','1','bareng kaka ini semua PR ku bisa selesai tepat waktu no worry Daring!','3',],
            ['10','1','bareng kaka ini semua PR ku bisa selesai tepat waktu no worry Daring!','2',],
        ];

        foreach ($allData as $data){
            DB::table('tb_reviews')->insert([
                'id_pelajar'    => $data[0],
                'id_mitra'      => $data[1],
                'pesan'         => $data[2],
                'rate'          => $data[3],
                'status'        => 'show',
            ]);
        }
    }
}
