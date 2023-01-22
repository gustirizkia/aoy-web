<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\DetailTransaksi;
use App\Models\ProdukSaya;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TransaksiController extends Controller
{
    public function index(Request $request){
        $invPembelian = Transaksi::where('jenis_inv', 'pembelian')->where('metode_pembayaran', '!=', null)->get()->pluck('id');
        $invPenjualan = Transaksi::where('jenis_inv', 'penjualan')->where('metode_pembayaran', '!=', null)->get()->pluck('id');

        $dataPembelian = DetailTransaksi::whereIn('transaksi_id', $invPembelian)->with('produk', 'transaksi')->get();
        $dataPenjualan = DetailTransaksi::whereIn('transaksi_id', $invPenjualan)->with('produk', 'transaksi')->get();


        return view('dashboard.transaksi.index', [
            'pembelian' => $dataPembelian,
            'penjualan' => $dataPenjualan,

        ]);

    }

    public function create(Request $request)
    {
        $produkSaya = ProdukSaya::where('user_id', auth()->user()->id)->with('produk')->get();
        $member = DB::table('levels')->where('id', auth()->user()->level)->first();

        return view('dashboard.transaksi.create', [
            'produk' => $produkSaya,
            'member' => $member
        ]);
    }

    public function stokReady($produk)
    {
        $isReady = true;
        for ($i=0; $i < count($produk); $i++) {
            $element = $produk[$i];
            $cek = DB::table('produk_sayas')->where('produk_id', $element['id'])->first();
            if($cek->qty < $element['qty']){
                $isReady = false;
                return $isReady;
            }
        }

        return $isReady;
    }

    public function invPenjualan(Request $request)
    {
        // dd($request->all());
        $validasi = Validator::make($request->all(), [
            'produk' => 'required'
        ]);
        if($validasi->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validasi->errors()
            ], 422);
        }

        $subTotal = 0;
        $user_id = auth()->user()->id;
        $level = DB::table('levels')->where('id', $user_id)->first();
        $diskon = 0;
        $jenisInv = 'penjualan';
        $noInv = 'AOY/INV/'.$user_id.time();
        $totalHarga = 0;

        $stokReady = $this->stokReady($request->produk);
        if(!$stokReady){
            return response()->json([
                'status' => 'error',
                'message' => 'stok produk tidak mencukupi',
                'stok_ready' => $stokReady
            ], 422);
        }

        $collectionProduk = collect();

        for ($i=0; $i < count($request->produk); $i++) {
            $element = $request->produk[$i];
            $produk = DB::table('produks')->find($element['id']);
            // dd($element['id'], $produk);
            $totalHargaProduk = $produk->harga*$element['qty'];
            $totalHarga += $totalHargaProduk;
            // dd($totalHarga, $produk, $element);

            $produkSaya = ProdukSaya::where('user_id', $user_id)->where('produk_id', $element['id'])->first();
            // return response()->json([(int)$produkSaya->qty, $element, auth()->user()->id]);
            if((int)$produkSaya->qty < $element['qty']){

                return response()->json([
                    'status' => 'error',
                    'message' => 'stok tidak mencukupi',
                    'no_inv' => $noInv
                ], 422);
            }elseif((int)$produkSaya->qty === $element['qty']){
                // delete prosuk
                $deleteProdukSaya = ProdukSaya::where('user_id', $user_id)->where('produk_id', $element['id'])->delete();
            }else{
                // kurangi stok produk
                $stokSekarang = $produkSaya->qty - $element['qty'];

                $produkSaya->update([
                    'qty' => $stokSekarang
                ]);
            }


            if($level->tipe_potongan === 'fix')
            {
                // potong tiap produk
                $potonganProduk = $level->potongan_harga*$element['qty'];
                $diskon += $potonganProduk;
                $subTotal += $totalHargaProduk - $potonganProduk;

            }

            $cekInv = DB::table('transaksis')->where('no_inv', $noInv)->first();
            $transaksi_id = null;
            if(!$cekInv){
                $insertTransaksi = Transaksi::create([
                    'status' => 'selesai',
                    'metode_pembayaran' => 'offline',
                    'biaya_pengiriman' => 0,
                    'admin_pembayaran' => 0,
                    'metode_pengiriman' => 'offline',
                    'payment_at' => now(),
                    'total_harga_barang' => $totalHarga,
                    'sub_total' => $subTotal,
                    'diskon'=> $diskon,
                    'user_id' => $user_id,
                    'jenis_inv' => $jenisInv,
                    'no_inv' => $noInv,
                    'pay_code' => 'offline',
                    'checkout_url' => 'offline',
                    'expired_time' => now(),
                    'payment_name' => 'offline',
                    'reference' => 'offline',
                    'fee_customer' => 0
                ]);
                $transaksi_id = $insertTransaksi->id;
            }else{
                $insertTransaksi = Transaksi::where('id', $cekInv->id)->update([
                    'status' => 'selesai',
                    'metode_pembayaran' => 'offline',
                    'biaya_pengiriman' => 0,
                    'admin_pembayaran' => 0,
                    'metode_pengiriman' => 'offline',
                    'payment_at' => now(),
                    'total_harga_barang' => $totalHarga,
                    'sub_total' => $subTotal,
                    'diskon'=> $diskon,
                    'user_id' => $user_id,
                    'jenis_inv' => $jenisInv,
                    'no_inv' => $noInv,
                    'pay_code' => 'offline',
                    'checkout_url' => 'offline',
                    'expired_time' => now(),
                    'payment_name' => 'offline',
                    'reference' => 'offline',
                    'fee_customer' => 0
                ]);
                $transaksi_id = $cekInv->id;
            }

            $insertDetailTransaksi = DetailTransaksi::create([
                'produk_id' => $produk->id,
                'transaksi_id' => $transaksi_id,
                'qty' => $element['qty'],
                'harga' => $produk->harga,
                'potong' => $potonganProduk,
            ]);

            $collectionProduk->push($produk);

        }

        return response()->json([
            'status' => 'success',
            'data' => $collectionProduk
        ]);
    }
}
