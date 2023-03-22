<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function tambahAlamat(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'province_id' => 'required|exists:provinces_ro,province_id',
            'city_id' => 'required|exists:subdistricts_ro,city_id',
            'subdistrict_id' => 'required'
        ]);
        if($validasi->fails())
        {
            return response()->json([
                'status' => 'error',
                'message' => $validasi->errors()
            ], 422);
        }

        $cek = DB::table('users_address')->where('user_id', auth()->user()->id)->where('status', 1)->first();
        if($cek){
            $cek = DB::table('users_address')->where('user_id', auth()->user()->id)->where('status', 1)->update([
                'status' => 2
            ]);
        }

      $insert = DB::table('users_address')->insertGetId([
        'city_id' => $request->city_id,
        'province_id' => $request->province_id,
        'created_at' => now(),
        'updated_at' => now(),
        'status' => 1,
        'user_id' => auth()->user()->id,
        'address' => $request->address,
        'subdistrict_id' => $request->subdistrict_id
      ]);

      $get = DB::table('users_address')
        ->join('subdistricts_ro', 'users_address.city_id', 'subdistricts_ro.city_id')
        ->join('provinces_ro', 'users_address.province_id', 'provinces_ro.province_id')
        ->select('users_address.*', 'subdistricts_ro.name as nama_kota', 'provinces_ro.name as nama_provinsi')
        ->where('users_address.id', $insert)->first();

      return response()->json($get);
    }

    public function getNotif(){
        $data = Notification::where('user_uuid', auth()->user()->uuid)->get();

        return response()->json($data);
    }
}
