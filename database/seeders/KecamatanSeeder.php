<?php

namespace Database\Seeders;

use GuzzleHttp\Client;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KecamatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kota = DB::table('subdistricts_ro')->get();
        foreach($kota as $item)
        {
            $client = new Client();
            $data = $client->get('https://pro.rajaongkir.com/api/subdistrict?city=' . $item->city_id,[
                'headers' => [
                // 'key' => 'a906fd8fc45a816184224df29f246d93'
                'key' => '437db99af91a23c64bf1bed279bc4d0f'
                ],
            ]);

            $subdistrict = json_decode($data->getBody())->rajaongkir->results;
            foreach($subdistrict as $kecamatan){
                DB::table('tb_ro_subdistricts')->insert([
                    'city_id' => $item->id,
                    'subdistrict_name' => $kecamatan->subdistrict_name,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
    }
}
