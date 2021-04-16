<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HargaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tb_hargas')->delete();

        $arrHarga = [
            [
                'Trenggalek',
                '27500',
                '33000',
                '44000',
                '44000',
                '44000'
            ],
            [
                'Malang',
                '44000',
                '66000',
                '71500',
                '71500',
                '77000'
            ],
            [
                'Surabaya',
                '44000',
                '66000',
                '82500',
                '88000',
                '99000'
            ],
        ];
        foreach ($arrHarga as $hrg){
            DB::table('tb_hargas')->insert([
                'kota'   => $hrg[0],
                'sd'     => $hrg[1],
                'smp'    => $hrg[2],
                'sma-10' => $hrg[3],
                'sma-11' => $hrg[4],
                'sma-12' => $hrg[5],
            ]);
        }
    }
}
