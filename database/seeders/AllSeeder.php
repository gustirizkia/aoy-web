<?php

namespace Database\Seeders;

use App\Http\Controllers\UtilsController;
use App\Models\ListKecamatan;
use App\Models\ListKota;
use App\Models\ListProvinsi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class AllSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        for ($i=1; $i < 100; $i++) {
            $provinsi = ListProvinsi::inRandomOrder()->first();
            $kota = ListKota::inRandomOrder()->first();
            $kecamatan = ListKecamatan::inRandomOrder()->first();
            $uuid = new UtilsController();
            $data_uuid = $uuid->generateUuid('users');

            $userName = \Str::random(5);
            $userName = 'aoy-'.$userName;

            $user = DB::table('users')->insertGetId([
                'name' => $faker->name,
                'email' => $faker->email,
                'password' => '$2y$10$k244jh8gpGQo2SeiSMJ8i.lafgsC.2ozppbeq/vYepPQdG8arr.ha', //12345678
                'level' => 1,
                'ref_id' => 1,
                'photo' => 'user/profile/hcrCAjVMU3IDRwTtePlr2ZCDnGLOiB8jBvemNBYx.jpg',
                'created_at' => now(),
                'updated_at' => now(),
                'uuid' => $data_uuid,
                'username' => $userName
            ]);

            $address = DB::table('users_address')->insertGetId([
                'user_id' => $user,
                'address' => $faker->address,
                'subdistrict_id' => $kecamatan->subdistrict_id,
                'city_id' => $kota->city_id,
                'province_id' => $provinsi->province_id,
                'created_at' => now(),
                'updated_at' => now(),
                'status' => 1
            ]);

            $member = DB::table('members')->insertGetId([
                'user_uuid' => $data_uuid,
                'akun_ig' => 'fiersabesari',
                'nomor_wa' => '083892870720',
                'image' => 'toko/THErguVHyAzaDArrAAcAOzsZCQ3Mz6BmnmHdqEBN.jpg',
                'nama' => $faker->name." Store",
                'deskripsi' => $faker->paragraph($nbSentences = 3, $variableNbSentences = true),
                'subdistrict_id' => $kecamatan->subdistrict_id,
                'city_id' => $kota->city_id,
                'province_id' => $provinsi->province_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            for ($k=1; $k < 4; $k++) {
                $gallery = DB::table('member_galleries')->insertGetId([
                    'member_id' => $member,
                    'image' => 'store/image/8IwLWSSPIBVyaFVSxRMWM2dF4doyMfeLwHAaca3F.jpg',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
