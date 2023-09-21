<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DetailTransaksi;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {

        $pembelian_member = Transaksi::where('jenis_inv', 'pembelian');
        $penjualan = Transaksi::where('jenis_inv', 'penjualan');

        $subtotal_penjualan_member = $penjualan
                                ->whereNotIn('status',  ['UNPAID', 'EXPIRED', 'FAILED'])->sum('sub_total');
        $subtotal_pembelian_member = $pembelian_member
                                ->whereNotIn('status',  ['UNPAID', 'EXPIRED', 'FAILED'])->sum('sub_total');

        $memberStok = DB::table('produk_sayas')->sum('qty');
        $barang_terjual = DetailTransaksi::whereIn('transaksi_id', $penjualan->pluck('id'))->sum('qty');

        return view('admin.dashboard', compact('subtotal_penjualan_member', 'memberStok', 'subtotal_pembelian_member', 'barang_terjual'));
    }
}
