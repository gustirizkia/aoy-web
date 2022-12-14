<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Transaksi;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->all();
        $data['user'] = auth()->user();
        return response()->json($data);

        return view('Frontend.transaksi.index');
    }

    public function cretaeInvPembelian(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'carts' => 'required',
            'level_id' => 'required'
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
        // $level = DB::table('levels')->where('id', )

        for ($i=0; $i < count($carts); $i++) {
            $cart = DB::table('carts')
                ->join('produks', 'carts.produk_id', 'produks.id')
                ->where('carts.id', $carts[$i])->first();
            // $diskon =
        }

        $produks = DB::table('produks')->whereIn('id', $request->produks)->get();
    }

    public function menungguPembayaran(Request $request)
    {

        $apiKey       = env('TRIPAY_API_KEY');
        $privateKey   = env('TRIPAY_PRIVAT_KEY');
        $merchantCode = env("TRIPAY_MERCHENT");
        $merchantRef  = \Str::random(13);
        $amount       = 1000000;
        $metode_pembayaran = 'MANDIRIVA';
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
                    'price'       => 500000,
                    'quantity'    => 1,
                    'product_url' => 'https://tokokamu.com/product/nama-produk-1',
                    'image_url'   => 'https://tokokamu.com/product/nama-produk-1.jpg',
                ],
                [
                    'sku'         => 'FB-07',
                    'name'        => 'Nama Produk 2',
                    'price'       => 500000,
                    'quantity'    => 1,
                    'product_url' => 'https://tokokamu.com/product/nama-produk-2',
                    'image_url'   => 'https://tokokamu.com/product/nama-produk-2.jpg',
                ]
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


        $transaksi = Transaksi::create([
            'user_id' => 1,
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
            'payment_at' => null
        ]);

        return view('Frontend.transaksi.menunggu');
    }

    public function rincian(Request $request)
    {
        return view('Frontend.transaksi.rincian');
    }
}
