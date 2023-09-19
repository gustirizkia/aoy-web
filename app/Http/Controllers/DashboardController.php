<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // dd(Session::get('level'));
        $now = Carbon::now();

        $transksi = Transaksi::where('user_id', auth()->user()->id)->where('status', '!=', 'create')->where('metode_pembayaran', '!=', null)->get()->pluck('id');
        $detailTransaki = DetailTransaksi::whereIn('transaksi_id', $transksi)->with('produk', 'transaksi')->get();

        $statusTransaksi = Transaksi::where('user_id', auth()->user()->id)->get();

        $utils = new UtilsController();
        $totalPenjualan = $utils->Totalpenjualan()['total_harga'];
        $totalPembelian = $utils->totalPembelian()['total_harga'];

        return view('dashboard.index', [
            'detail_transaksi' => $detailTransaki,
            'count_unpaid' => Transaksi::where('user_id', auth()->user()->id)->where('status', 'UNPAID')->count(),
            'count_dikemas' => Transaksi::where('user_id', auth()->user()->id)->where('status', 'PAID')->orWhere('status', 'dikemas')->count(),
            'count_dikirim' => $statusTransaksi->where('status', 'dikirim')->count(),
            'count_penilaian' => $statusTransaksi->where('status', 'penilaian')->count(),
            'count_selesai' => $statusTransaksi->where('status', 'selesai')->count(),
            'total_penjualan' => $totalPenjualan,
            'total_pembelian' => $totalPembelian,
            'stok' => $utils->stok()['stok'],
            'total_qty' => $utils->stok()['jumlah_pembelian']

        ]);
    }
}
