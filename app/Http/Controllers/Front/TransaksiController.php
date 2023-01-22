<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\DetailTransaksi;
use App\Models\ListKota;
use App\Models\ListProvinsi;
use App\Models\Transaksi;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        if(!$request->inv){
            return redirect()->back();
        }

        $inv = Transaksi::where('no_inv', $request->inv)->first();
        $detailTransaksi = DetailTransaksi::where('transaksi_id', $inv->id)->with('produk')->get();

        $client = new Client();

        try {
            $result = $client->request('get', env("TRIPAY_URL").'merchant/payment-channel', [
                'headers' => [
                            'Authorization' => "Bearer " . env('TRIPAY_API_KEY'),
                    ],
            ]);

            $res = json_decode($result->getBody());
            // dd($res->data);
            $res = $res->data;

        } catch (BadResponseException $e) {
            $res = null;
            return redirect()->back();
        }

        $address = DB::table('users_address')->where('user_id', auth()->user()->id)->get();
        // dd($address);

        $addressActive = DB::table('users_address')
            ->join('subdistricts_ro', 'users_address.city_id', 'subdistricts_ro.city_id')
            ->join('provinces_ro', 'users_address.province_id', 'provinces_ro.province_id')
            ->where('status', 1)
            ->select('users_address.*', 'subdistricts_ro.name as nama_kota', 'provinces_ro.name as nama_provinsi')
            ->where('user_id', auth()->user()->id)->first();

        $listProvinsi = ListProvinsi::get();
        $listKota = ListKota::get();

        return view('Frontend.transaksi.index', [
            'transaksi' => $inv,
            'detail_transaksi' => $detailTransaksi,
            'channel_pembayaran' => $res,
            'address_active' => $addressActive,
            'address' => $address,
            'list_provinsi' => $listProvinsi,
            'list_kota' => $listKota
        ]);
    }

    public function createInv(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'carts' => 'required',
        ]);

        if($validasi->fails())
        {
            return response()->json([
                'status' => 'error',
                'message' => $validasi->errors()
            ], 422);
        }

        $carts = $request->carts;
        $subTotal = 0;

        $user_id = auth()->user()->id;
        $level = DB::table('levels')->where('id', $user_id)->first();
        $diskon = 0;
        $jenisInv = 'pembelian';
        $noInv = 'AOY/INV/'.$user_id.time();
        $totalHarga = 0;

        // return response()->json($level);

        $collectionProduk = collect();

        for ($i=0; $i < count($carts); $i++) {
            $cart = DB::table('carts')
                ->where('carts.id', $carts[$i])->first();

            // dd($cart->produk_id);
            $produk = DB::table('produks')->where('id', $cart->produk_id)->first();
            $totalHargaProduk = $produk->harga*$cart->qty;
            $totalHarga += $totalHargaProduk;

            if($level->tipe_potongan === 'fix')
            {
                // potong tiap produk
                $potonganProduk = $level->potongan_harga*$cart->qty;
                $diskon += $potonganProduk;
                $subTotal += $totalHargaProduk - $potonganProduk;

            }else{
                $nilai = ($level->potongan_harga/100)*$produk->harga;
                $potonganProduk = $nilai*$cart->qty;

                $diskon += $potonganProduk;
                $subTotal += $totalHarga - $potonganProduk;
            }

            $cekInv = Transaksi::where('no_inv', $noInv)->first();
            if($cekInv){
                $createInv = Transaksi::where('no_inv', $noInv)->update([
                    'user_id' => $user_id,
                    'no_inv' => $noInv,
                    'jenis_inv' => $jenisInv,
                    'sub_total' => $subTotal,
                    'status' => 'create',
                    'total_harga_barang' => $totalHarga,
                    'diskon' => $diskon
                ]);

                $createInv = Transaksi::where('no_inv', $noInv)->first();
                // return response()->json($createInv);
            }else{
                $createInv = Transaksi::create([
                    'user_id' => $user_id,
                    'no_inv' => $noInv,
                    'jenis_inv' => $jenisInv,
                    'sub_total' => $subTotal,
                    'status' => 'create',
                    'total_harga_barang' => $totalHarga,
                    'diskon' => $diskon
                ]);
            }

            $transaksi_id = $createInv->id;


            $insertDetailTransaksi = DetailTransaksi::create([
                'produk_id' => $produk->id,
                'transaksi_id' => $transaksi_id,
                'qty' => $cart->qty,
                'harga' => $produk->harga,
                'potong' => $potonganProduk,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $collectionProduk->push($produk);
        }


        $carts = DB::table('carts')->whereIn('id', $carts)->get();

        return response()->json([
            'status' => 'success',
            'carts' => $carts,
            'produks' => $collectionProduk,
            'inv' => $createInv,
            'level' => $level
        ], 201);




    }

    public function prosesInv(Request $request){

    }

    public function checkoutInv(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'no_inv' => 'required|exists:transakis,no_inv',
            'biaya_pengiriman' => 'required',
            'admin_pembayaran' => 'required',
            'metode_pembayaran' => 'required',
            // 'metode_pengiriman' => 'required'

        ]);


        if($validasi->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validasi->errors()
            ], 422);
        }


        $data = $request->all();
        $data['metode_pengiriman'] = 'jne';
        $data['biaya_pengiriman'] = 10000;
        $data['status_unpaid'] = 10000;




    }

    public function menungguPembayaran(Request $request)
    {
        $inv = Transaksi::where('no_inv', $request->no_inv)->first();

        $apiKey       = env('TRIPAY_API_KEY');
        $privateKey   = env('TRIPAY_PRIVAT_KEY');
        $merchantCode = env("TRIPAY_MERCHENT");
        $merchantRef  = $request->no_inv;
        $amount       = $inv->sub_total;
        $metode_pembayaran = $request->metode_pembayaran;
        $biaya_pengiriman = 10000;
        // dd($merchantRef);

        $data = [
            'method'         => $metode_pembayaran,
            'merchant_ref'   => $merchantRef,
            'amount'         => $amount,
            'customer_name'  => 'Nama Pelanggan Tester',
            'customer_email' => 'emailpelanggan@domain.com',
            'customer_phone' => '081234567890',
            'order_items'    => [
                [
                    'sku'         => 'FB-06',
                    'name'        => 'Nama Produk 1',
                    'price'       => $amount,
                    'quantity'    => 1,
                    'product_url' => 'https://tokokamu.com/product/nama-produk-1',
                    'image_url'   => 'https://tokokamu.com/product/nama-produk-1.jpg',
                ],
            ],
            'return_url'   => 'https://domainanda.com/redirect',
            'expired_time' => (time() + (24 * 60 * 60)), // 24 jam
            'signature'    => hash_hmac('sha256', $merchantCode.$merchantRef.$amount, $privateKey)
        ];

        $client = new Client();
        $result = $client->request('post', env("TRIPAY_URL").'transaction/create', [
            'headers' => [
                        'Authorization' => "Bearer " . $apiKey,
                ],
            'form_params' => $data
        ]);

        $res = json_decode($result->getBody());


        $transaksi = Transaksi::where('no_inv', $merchantRef)->update([
            'user_id' => auth()->user()->id,
            'no_inv' => $merchantRef,
            'jenis_inv' => 'pembelian',
            'metode_pembayaran' => $metode_pembayaran,
            'biaya_pengiriman' => $biaya_pengiriman,
            'sub_total' => $amount,
            'status' => $res->data->status,
            'payment_name' => $res->data->payment_name,
            'fee_customer' => $res->data->fee_customer,
            'expired_time' => $res->data->expired_time,
            'checkout_url' => $res->data->checkout_url,
            'pay_code' => $res->data->pay_code,
            'admin_pembayaran' => $res->data->fee_merchant,
            'payment_at' => null,
            'reference' => $res->data->reference
        ]);

        $inv = Transaksi::where('no_inv', $request->no_inv)->first();
        $detailTransaksi = DetailTransaksi::where('transaksi_id', $inv->id)->get();
        foreach($detailTransaksi as $item){
            $cartUser = Cart::where('user_id', $inv->user_id)->where('produk_id', $item->produk_id)->first();
            if($item->qty >= $cartUser->qty){
                $cartUser->delete();
            }else{
                $qty = $cartUser->qty-$item->qty;
                $cartUser->update('qty', $qty);
            }
        }

        return response()->json($inv);
    }

    public function unpaid(Request $request)
    {
        $inv = $request->inv;
        $apiKey       = env('TRIPAY_API_KEY');

        $transaksi = Transaksi::where('no_inv', $inv)->first();

        $client = new Client();
        $result = $client->request('get', env("TRIPAY_URL").'transaction/detail?reference='.$transaksi->reference, [
            'headers' => [
                        'Authorization' => "Bearer " . $apiKey,
                ],
        ]);

        $res = json_decode($result->getBody());

        return view('Frontend.transaksi.menunggu', [
            'item' => $res->data
        ]);
    }

    public function rincian(Request $request)
    {
        return view('Frontend.transaksi.rincian');
    }
}
