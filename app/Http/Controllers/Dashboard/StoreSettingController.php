<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Level;
use App\Models\Member;
use App\Models\MemberGallery;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class StoreSettingController extends Controller
{
    public function index(Request $request)
    {
        $member = Member::where('user_uuid', auth()->user()->uuid)->first();
        $gallery = MemberGallery::where('member_id', auth()->user()->id)->get();

        $provinsi = DB::table('provinces_ro')->orderBy('name', 'asc')->get();
        // dd($gallery, auth()->user()->id);

        if(!$member) {
            $level = Level::get();
            return view('dashboard.store.register-member', [
                'provinsi' => $provinsi,
                'level' => $level
            ]);
        }

        return view('dashboard.store.index', [
            'member' => $member,
            'gallery' => $gallery,
            'provinsi' => $provinsi
        ]);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $data = [
            'image' => 'image|max:40240', // 4mb
            'nama' => 'required|string',
            'akun_ig' => 'required|string',
            'nomor_wa' => 'required|string',
            'deskripsi' => 'required',
            'city_id' => 'required|exists:subdistricts_ro,city_id',
            'kecamatan_id' => 'required|exists:tb_ro_subdistricts,subdistrict_id',
            'provinsi' => 'required|exists:provinces_ro,province_id',
            'jalan' => 'required|string'
        ];

        // if($request->daftar_seller) {
        //     $data['paket'] = 'required';
        // }

        $request->validate($data, [
            'required' => ':attribute wajib di isi',
            'max' => 'image maksimal 4 mb',
            'exists' => ":attribute tidak ada"
        ]);

        $data = [
            'user_uuid' => auth()->user()->uuid,
            'akun_ig' => $request->akun_ig,
            'nomor_wa' => $request->nomor_wa,
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'province_id' => $request->provinsi,
            'city_id' => $request->city_id,
            'subdistrict_id' => $request->kecamatan_id,
            'jalan' => $request->jalan
        ];


        // if($request->daftar_seller) {
        //     // User::where('id', auth()->user()->id)->update([
        //     //     'level' => $request->level
        //     // ]);
        // }

        $data['status'] = 3;

        if($request->image) {
            $image = $request->image->store('toko', 'public');
            $data['image'] = $image;
        }


        $insert = Member::updateOrCreate([
            "user_uuid" => auth()->user()->uuid
        ], $data);

        return redirect()->back()->with('success', 'Berhasil simpan data store kamu');


    }

    public function uploadImage(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'image' => 'image|max:50240' ///5mb
        ]);
        if($validasi->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validasi->errors()
            ], 422);
        }

        $image = $request->image->store('store/image', 'public');
        // $member = 1;
        $insert = MemberGallery::create([
            'member_id' => auth()->user()->id,
            'image' => $image
        ]);

        return response()->json($insert);
    }

    public function deleteImage(Request $request)
    {
        $id = $request->id;
        if(!$id) {
            return redirect()->back()->with('error', "Data tidak ditemukan");
        }

        $delete = DB::table('member_galleries')->where('member_id', auth()->user()->id)->where('id', $id)->delete();

        return redirect()->back()->with('success', "Berhasil hapus photo");
    }
}
