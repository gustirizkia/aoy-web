<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\ListProvinsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $member = DB::table('members')
                    ->join('users', 'members.user_uuid', 'users.uuid')
                    ->join('levels', 'users.level', 'levels.id')
                    ->join('provinces_ro', 'members.province_id', 'provinces_ro.province_id')
                    ->join('subdistricts_ro', 'members.city_id', 'subdistricts_ro.city_id')
                    ->join('tb_ro_subdistricts', 'members.subdistrict_id', 'tb_ro_subdistricts.subdistrict_id')
                    ->select('members.*', 'provinces_ro.name as provinsi', 'subdistricts_ro.name as kota', 'users.name', 'users.username', 'tb_ro_subdistricts.subdistrict_name', 'levels.nama as level_nama')
                    ->orderBy('members.id', 'desc')->paginate(6);
        $provinsi = ListProvinsi::orderBy('name', 'asc')->get();

        return view('Frontend.seller', compact('member', 'provinsi'));
    }

    public function getMember(Request $request){
        $member = DB::table('members')
                    ->join('users', 'members.user_uuid', 'users.uuid')
                    ->join('levels', 'users.level', 'levels.id')
                    ->join('provinces_ro', 'members.province_id', 'provinces_ro.province_id')
                    ->join('subdistricts_ro', 'members.city_id', 'subdistricts_ro.city_id')
                    ->join('tb_ro_subdistricts', 'members.subdistrict_id', 'tb_ro_subdistricts.subdistrict_id')
                    ->select('members.*', 'provinces_ro.name as provinsi', 'subdistricts_ro.name as kota', 'users.name', 'users.username', 'tb_ro_subdistricts.subdistrict_name', 'levels.nama as level_nama')
                    ->orderBy('members.id', 'desc')->paginate(6);

        return response()->json($member);
    }
}
