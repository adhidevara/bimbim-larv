<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([

            BidangTableSeeder::class,
            HargaTableSeeder::class,
            ProvinsiTableSeeder::class,
            KotaTableSeeder::class,
            KecamatanTableSeeder::class,
            KelurahanTableSeeder::class,

            //Optional Callable
            MitraTableSeeder::class,
            PelajarTableSeeder::class,
            ReviewTableSeeder::class,
            MapelUnggulanTableSeeder::class,
        ]);
    }
}
