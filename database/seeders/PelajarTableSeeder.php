<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PelajarTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        DB::table('tb_pelajars')->delete();
        for ($i = 0; $i < 10; $i++){
            $allData = [
                'nama'      => $faker->name,
                'email'     => $faker->safeEmail,
                'password'  => Hash::make('password'),
            ];

            $user = User::create($allData);
            DB::table('tb_pelajars')->insert([
                'id_user'   => $user->id,
                'nama'      => $faker->name,
                'pendidikan'=> 'sma-'.rand(10,12),
                'no_telepon'=> str::random(12),
                'email'     => $faker->safeEmail,
                'password'  => Hash::make('password'),
                'kota'      => $faker->city,
                'provinsi'  => $faker->country,
                'alamat'    => $faker->streetAddress,
                'bio'       => $faker->paragraph,
                'foto'      => $faker->imageUrl('720', '480'),
                'is_verified'=> 1
            ]);
        }

    }
}
