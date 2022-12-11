<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $request->session()->put('current_page', '/');
        $request->session()->put('prev', URL::previous());

        $rekomendasi_produk = DB::table('produk_rekomendasis')->limit(3)->get()->pluck('produk_id');
        $produkRekomendasi = Produk::whereIn('id', $rekomendasi_produk)->get();
        $produkTerbaru = Produk::orderBy('id', 'desc')->limit(3)->get();

        return view('Frontend.home', [
            'rekomendasi' => $produkRekomendasi,
            'terbaru' => $produkTerbaru
        ]);
    }
}
