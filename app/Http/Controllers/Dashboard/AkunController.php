<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ListKota;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AkunController extends Controller
{
    public function index(Request $request){
        $user= auth()->user();
        $member = DB::table('members')->where('user_uuid', $user->uuid)->first();
        $alamat = UserAddress::where('user_id', auth()->user()->id)->with('provinsi', 'kota', 'kecamatan')->get();
        $provinsi = DB::table('provinces_ro')->orderBy('name', 'asc')->get();
        $alamatUtama = UserAddress::where('user_id', auth()->user()->id)->where('status', 1)->orderBy('id', 'desc')->first();
        // dd($alamatUtama);
        return view('dashboard.akun.index', [
            'user' => $user,
            'member' => $member,
            'alamat' => $alamat,
            'provinsi' => $provinsi,
            'alamat_utama' => $alamatUtama
        ]);
    }

    public function editAlamat($id){
        $alamat = UserAddress::where('user_id', auth()->user()->id)
                    ->where('id', $id)
                    ->with('provinsi', 'kecamatan', 'kota')
                    ->orderBy('id', 'desc')->first();
        if(!$alamat){
            return redirect()->route('akun-saya');
        }
        $kota = DB::table('subdistricts_ro')->orderBy('name', 'asc')->where('province_id', $alamat->provinsi->id)->get();
        $kecamatan = DB::table('tb_ro_subdistricts')->orderBy('name', 'asc')->where('city_id', $alamat->kota->id);
        $provinsi = DB::table('provinces_ro')->orderBy('name', 'asc')->get();
        // dd($alamat);
        return view('dashboard.akun.edit-alamat', [
            'alamat' => $alamat,
            'provinsi' => $provinsi,
            'kota' => $kota,
            'kecamatan' => $kecamatan
        ]);
    }

    public function updateProfile(Request $request){
        $request->validate([
            'nama' => 'required|string',
            'nomor_wa' => 'required|numeric',
            'photo' => 'image|max:5192', //5240 5mb
        ], [
            'required' => ':attribute tidak boleh kosong',
            'max' => ':attribute tidak boleh lebih dari 5mb',
            'confirmed' => ':attribute tidak sama',
            'min' => ':attribute minimal 6 karakter'
        ]);
        $formUser = [
            'name' => $request->nama,
        ];

        if($request->photo){
            $photo = $request->photo->store('user/profile', 'public');
            $formUser['photo'] = $photo;
        }

        if($request->password || $request->password_confirmation){
            if(strlen($request->password) <= 5){
                return redirect()->back()->with('error', 'password minimal 6 karakter');
            } elseif($request->password !== $request->password_confirmation){
                return redirect()->back()->with('error', 'password tidak sama silahkan buat ulang password anda');
            }else{
                $password = Hash::make($request->password);
                $formUser['password'] = $password;
            }
        }

        $userUpdate = Db::table('users')->where('id', auth()->user()->id)->update($formUser);

        return redirect()->back()->with('success', 'Berhasil ubah profile anda');
    }
}
