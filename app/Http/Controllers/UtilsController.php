<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UtilsController extends Controller
{
    public function generateUuid($table)
    {
        $string = Str::random(13);
        $cek = DB::table($table)->where('uuid', $string)->first();
        if($cek)
        {
         return   $this->generateUuid($table);
        }else{
            return $string;
        }
    }

    public function keuntungan(){
        $pembelian = DB::table('transaksis')->where('user_id', auth()->user()->id)->where(function($query){
            return $query->where('status', 'selesai')->orWhere('status', 'penilaian');
        })->where('jenis_inv', 'pembelian')->sum('total_harga_barang');
        $penjualan = DB::table('transaksis')->where('user_id', auth()->user()->id)->where('jenis_inv', '!=', 'pembelian')->sum('total_harga_barang');
        // $total = $penjualan%$pembelian;
    }

    public function Totalpenjualan(){
        $penjualan = DB::table('transaksis')->where('user_id', auth()->user()->id)->where('jenis_inv', '!=', 'pembelian');
        $detail = DB::table('detail_transaksis')->whereIn('transaksi_id', $penjualan->get()->pluck('id'));
        return [
            'total_harga' => $penjualan->sum('total_harga_barang'),
            'total_qty' => $detail->sum('qty')
        ];
    }
}
