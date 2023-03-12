<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        if($request->q){
            $kategori = $kategori = DB::table('kategori_produks')->where('slug', $request->q)->first();
            if($kategori){
                $cek = Produk::when($request->search, function($query)use($search){
                    return $query->where('nama', 'LIKE', "%$search%");
                })->where('kategori_produk_id', $kategori->id)->orderBy('id', 'desc')->get();
                if(count($cek) > 0){
                    $data = $cek;
                }else{
                    $data = Produk::when($request->search, function($query)use($search){
                        return $query->where('nama', 'LIKE', "%$search%");
                    })->orderBy('id', 'desc')->get();
                }
            }
        }else{
            $data = Produk::when($request->search, function($query)use($search){
                return $query->where('nama', 'LIKE', "%$search%");
            })->orderBy('id', 'desc')->get();
        }

        $kategori = DB::table('kategori_produks')->get();
        $banner = DB::table('banner')->where('page', 'produk')->orderBy('id', 'desc')->get();

        return view('Frontend.produk', [
            'items' => $data,
            'kategori' => $kategori,
            'banner' => $banner
        ]);
    }
}
