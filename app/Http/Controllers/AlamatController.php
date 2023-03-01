<?php

namespace App\Http\Controllers;

use App\Models\ListKecamatan;
use App\Models\ListKota;
use App\Models\ListProvinsi;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AlamatController extends Controller
{
    public function provinsi(){
        $data = ListProvinsi::orderBy('name', 'asc')->get();

        return response()->json($data);
    }

    public function kota(Request $request){
        $provinsi_id = $request->provinsi_id;
        $data = ListKota::where('province_id', $provinsi_id)->orderBy('name', 'asc')->get();

        return response()->json($data);
    }

    public function kecamatan(Request $request){
        $city_id = $request->city_id;
        $data = ListKecamatan::where('city_id', $city_id)->orderBy('subdistrict_name', 'asc')->get();

        return response()->json($data);

    }

    public function changeActive(Request $request)
    {
        $update = DB::table('users_address')->where('user_id', auth()->user()->id)->where('id', $request->address_id)->update([
            'status' => 1
        ]);
        $changeStatus = DB::table('users_address')->where('user_id', auth()->user()->id)->where('id', '!=', $request->address_id)->update([
            'status' => 2
        ]);

        return response()->json('OK');
    }

    // public function tambahAlamat(Request $request){
    //     $validasi = Validator::make($request->all(), [
    //         'address' => 'required|string',
    //         'city_id' => 'required|exists:subdistricts_ro,city_id',
    //         'provinsi_id' => 'required|exists:provinces_ro,provinces_ro',
    //         'kecamatan_id' => 'required|exists:tb_ro_subdistricts,subdistrict_id'
    //     ]);
    //     if($validasi->fails()){
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => $validasi->errors()
    //         ], 422);
    //     }

    //     $data = UserAddress::create([
    //         'user_id' => auth()->user()->id,
    //         'address' => $request->address,
    //         'city_id' => $request->city_id,
    //         'subdistrict_id' => $request->kecamatan_id
    //     ]);

    //     return response()->json($data);
    // }
}
