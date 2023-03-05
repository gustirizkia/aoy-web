<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Controllers\UtilsController;
use App\Models\DetailTransaksi;
use App\Models\ProdukSaya;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $transaksi = Transaksi::where("user_id", auth()->user()->id)->where(function($query){
            return $query->where('status', 'selesai')->orWhere('status', 'penilaian')->orWhere('status', 'konfirmasi');
        })->where('jenis_inv', 'pembelian')->get()->pluck('id');

        $detail_transaksi = DetailTransaksi::whereIn('transaksi_id', $transaksi)->with('produk.kategori', 'transaksi')->get()->pluck("produk_id");
        $produk = ProdukSaya::whereIn('produk_id', $detail_transaksi)->with('produk.kategori')->get();

        $totalPembelian = DetailTransaksi::whereIn('transaksi_id', $transaksi)->sum('qty');

        $utils = new UtilsController;
        $totalPenjualan = $utils->Totalpenjualan()['total_harga'];

        return view('dashboard.produk.index', [
            'detail_transaksi' => $detail_transaksi,
            'total_pembelian' => $totalPembelian,
            'produk' => $produk,
            'total_penjualan' => $totalPenjualan
        ]);
    }
}
