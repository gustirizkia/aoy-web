<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\DetailTransaksi;
use App\Models\ProdukSaya;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $transaksi = Transaksi::where("user_id", auth()->user()->id)->where('status', 'selesai')->get()->pluck('id');
        $detail_transaksi = DetailTransaksi::whereIn('transaksi_id', $transaksi)->with('produk.kategori', 'transaksi')->get()->pluck('produk_id');
        $produk = ProdukSaya::whereIn('produk_id', $detail_transaksi)->with('produk.kategori')->get();


        return view('dashboard.produk.index', [
            'detail_transaksi' => $detail_transaksi,
            'produk' => $produk
        ]);
    }
}
