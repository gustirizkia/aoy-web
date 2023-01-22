<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\MemberGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StoreSettingController extends Controller
{
    public function index(Request $request)
    {
        $member = Member::where('user_uuid', auth()->user()->uuid)->first();
        $gallery = MemberGallery::where('member_id', auth()->user()->id)->get();
        // dd($gallery, auth()->user()->id);
        return view('dashboard.store.index', [
            'member' => $member,
            'gallery' => $gallery
        ]);
    }

    public function store(Request $request){
        $request->validate([
            'image' => 'image|max:40240', // 4mb
            'nama' => 'required|string',
            'akun_ig' => 'required|string',
            'nomor_wa' => 'required|string',
            'deskripsi' => 'required',
        ]);
        $data = [
            'user_uuid' => auth()->user()->uuid,
            'akun_ig' => $request->akun_ig,
            'nomor_wa' => $request->nomor_wa,
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi
        ];

        if($request->image){
            $image = $request->image->store('toko', 'public');
            $data['image'] = $image;
        }


        $insert = Member::updateOrCreate([
            "user_uuid" => auth()->user()->uuid
        ],$data);

        return redirect()->back()->with('success', 'Berhasil simpan data store kamu');


    }

    public function uploadImage(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'image' => 'image|max:50240' ///5mb
        ]);
        if($validasi->fails()){
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
}