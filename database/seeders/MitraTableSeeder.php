<?php

namespace Database\Seeders;

use App\Models\Mitra;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MitraTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        DB::table('tb_mitras')->delete();

        for ($i = 0; $i < 5; $i++){
            $allData = [
                'nama'      => $faker->name,
                'email'     => $faker->safeEmail,
                'password'  => Hash::make('password'),
            ];

            $user = User::create($allData);
            DB::table('tb_mitras')->insert([
                'id_user'   => $user->id,
                'nama'      => $faker->name,
                'email'     => $faker->safeEmail,
                'password'  => Hash::make('password'),
                'id_bidang' => 1,
                'no_telepon'=> str::random(12),
                'tgl_lahir' => $faker->date('Y-m-d H:i:s'),
                'jk'        => 'pria',
                'kota'      => $faker->city,
                'provinsi'  => $faker->country,
                'alamat'    => $faker->streetAddress,
                'institusi' => 'Universitas Negeri Surabaya',
                'prodi'     => 'S1 Administrasi Bisnis',
                'ipk'       => '3.00',
                'status_studi'  => 'aktif',
                'deskripsi' => $faker->paragraph,
                'foto'      => $faker->imageUrl('720', '480'),
                'video'     => $faker->imageUrl('720', '480'),
                'cv'        => $faker->imageUrl('720', '480'),
                'is_verified'=> 1
            ]);
        }
    }
}
