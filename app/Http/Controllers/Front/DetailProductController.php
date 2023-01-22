<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\DetailTransaksi;
use App\Models\ImageProduk;
use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DetailProductController extends Controller
{
    public function index(Request $request, $slug){
        $data = Produk::where('slug', $slug)->first();
        if(!$data){
            abort(404);
        }


        $image = ImageProduk::where('product_id', $data->id)->get();

        return view('Frontend.detail-produk', [
            'produk' => $data,
            'images' => $image
        ]);
    }

    public function orderLangsung(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'produk_id' => 'required|exists:produks,id'
        ]);

        if($validasi->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validasi->errors()
            ], 422);
        }

        $user_id = auth()->user()->id;
        $level = DB::table('levels')->where('id', $user_id)->first();
        $diskon = 0;
        $jenisInv = 'pembelian';
        $noInv = 'AOY/INV/'.$user_id.time();
        $totalHarga = 0;
        $subTotal = 0;

        $produk = DB::table('produks')->where('id', $request->produk_id)->first();
        $totalHargaProduk = $produk->harga;
        $totalHarga += $totalHargaProduk;

        if($level->tipe_potongan === 'fix')
        {
            // potong tiap produk
            $potonganProduk = $level->potongan_harga;
            $diskon += $potonganProduk;
            $subTotal += $totalHargaProduk - $potonganProduk;

        }else{
            $nilai = ($level->potongan_harga/100)*$produk->harga;
            $potonganProduk = $nilai;

            $diskon += $potonganProduk;
            $subTotal += $totalHarga - $potonganProduk;
        }

        $createInv = Transaksi::create([
                        'user_id' => $user_id,
                        'no_inv' => $noInv,
                        'jenis_inv' => $jenisInv,
                        'sub_total' => $subTotal,
                        'status' => 'create',
                        'total_harga_barang' => $totalHarga,
                        'diskon' => $diskon
                    ]);

        $insertDetailTransaksi = DetailTransaksi::create([
                                    'produk_id' => $produk->id,
                                    'transaksi_id' => $createInv->id,
                                    'qty' => 1,
                                    'harga' => $produk->harga,
                                    'potong' => $potonganProduk
                                ]);

        return response()->json([
            'status' => 'success',
            'produk' => $produk,
            'inv' => $createInv
        ]);


    }

    public function addCart(Request $request)
    {
        $data['produk_id'] = $request->produk_id;
        $data['user_id'] = $request->user_id;
        $data['qty'] = $request->qty;
        $data['created_at'] = now();

        $cek = DB::table('carts')->where('user_id', $request->user_id)->where('produk_id', $request->produk_id)->first();
        if($cek){
            if($request->status === 'minus')
            {
                $minusQty = $cek->qty - $data['qty'];
                $data['qty'] = $minusQty;

                if($data['qty'] <= 0)
                {
                    $delete = DB::table('carts')->where('user_id', $request->user_id)->where('produk_id', $request->produk_id)->delete();
                    return response()->json($data);
                }
            }else{
                $data['qty'] += $cek->qty;
            }
            $update = DB::table('carts')->where('user_id', $request->user_id)->where('produk_id', $request->produk_id)->update($data);
        }else{
            $insert = DB::table('carts')->insert($data);
        }

        return response()->json($data);
    }
}
