<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SellerController extends Controller
{
    public function filter(Request $request)
    {
        $province_id = $request->province_id;
        $city_id = $request->city_id;
        $username = $request->username;

        $member = DB::table('members')
                    ->join('users', 'members.user_uuid', 'users.uuid')
                    ->join('levels', 'users.level', 'levels.id')
                    ->join('provinces_ro', 'members.province_id', 'provinces_ro.province_id')
                    ->join('subdistricts_ro', 'members.city_id', 'subdistricts_ro.city_id')
                    ->join('tb_ro_subdistricts', 'members.subdistrict_id', 'tb_ro_subdistricts.subdistrict_id')
                    ->when($province_id, function($query)use($province_id){
                        return $query->where('members.province_id', $province_id);
                    })
                    ->when($city_id, function($query)use($city_id){
                        return $query->where('members.city_id', $city_id);
                    })
                    ->when($username, function($query)use($username){
                        return $query->where('users.username', "LIKE", "%$username%");
                    })
                    ->select('members.*', 'provinces_ro.name as provinsi', 'subdistricts_ro.name as kota', 'users.name', 'users.username', 'tb_ro_subdistricts.subdistrict_name', 'levels.nama as level_nama')
                    ->orderBy('members.id', 'desc')->paginate(6);

        return response()->json([
            'status' => 'success',
            'data' => $member,
            'username' => $username
        ]);
    }
}
