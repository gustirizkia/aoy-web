<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\ListProvinsi;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class HomeController extends Controller
{
    public function detailMember($username)
    {
        $member = DB::table('members')
                    ->where('users.username', $username)
                    ->join('users', 'members.user_uuid', 'users.uuid')
                    ->join('levels', 'users.level', 'levels.id')
                    ->join('provinces_ro', 'members.province_id', 'provinces_ro.province_id')
                    ->join('subdistricts_ro', 'members.city_id', 'subdistricts_ro.city_id')
                    ->join('tb_ro_subdistricts', 'members.subdistrict_id', 'tb_ro_subdistricts.subdistrict_id')
                    ->select('members.*', 'users.id as user_id', 'provinces_ro.name as provinsi', 'subdistricts_ro.name as kota', 'users.name', 'users.username', 'tb_ro_subdistricts.subdistrict_name', 'levels.nama as level_nama')
                    ->orderBy('members.id', 'desc')->first();
        $member_galleries = DB::table('member_galleries')->where('member_id', $member->user_id)->get();
        // dd($member_galleries, $member->id, $member);

        return view('Frontend.member-detail', compact('member', 'member_galleries'));
    }
    public function index(Request $request)
    {
        $request->session()->put('current_page', '/');
        $request->session()->put('prev', URL::previous());

        $rekomendasi_produk = DB::table('produk_rekomendasis')->limit(4)->get()->pluck('produk_id');
        $produkRekomendasi = Produk::whereIn('id', $rekomendasi_produk)->get();
        $produkTerbaru = Produk::orderBy('id', 'desc')->limit(4)->get();

        $provinsiList = ListProvinsi::orderBy('name', 'asc')->get();
        $member = DB::table('members')
                    ->join('users', 'members.user_uuid', 'users.uuid')
                    ->join('levels', 'users.level', 'levels.id')
                    ->join('provinces_ro', 'members.province_id', 'provinces_ro.province_id')
                    ->join('subdistricts_ro', 'members.city_id', 'subdistricts_ro.city_id')
                    ->join('tb_ro_subdistricts', 'members.subdistrict_id', 'tb_ro_subdistricts.subdistrict_id')
                    ->select('members.*', 'provinces_ro.name as provinsi', 'subdistricts_ro.name as kota', 'users.name', 'users.username', 'tb_ro_subdistricts.subdistrict_name', 'levels.nama as level_nama')
                    ->orderBy('members.id', 'desc')->paginate(6);

        return view('Frontend.home', [
            'rekomendasi' => $produkRekomendasi,
            'terbaru' => $produkTerbaru,
            'provinsi' => $provinsiList,
            'member' => $member
        ]);
    }
}
