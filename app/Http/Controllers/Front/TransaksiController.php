<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Controllers\OngkirController;
use App\Models\Cart;
use App\Models\DetailTransaksi;
use App\Models\ListKota;
use App\Models\ListProvinsi;
use App\Models\Notification;
use App\Models\Transaksi;
use App\Models\UserAddress;
use Carbon\Carbon;
use DateTime;
use Exception;
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
        if (!$request->inv) {
            return redirect()->back();
        }


        $inv = Transaksi::where('no_inv', $request->inv)->where('user_id', auth()->user()->id)->first();

        if (!$inv) {
            return redirect()->back();
        }

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

        $address = UserAddress::where('user_id', auth()->user()->id)->orderBy('id', 'desc')->with('provinsi', 'kota', 'kecamatan')->get();


        $addressActive = DB::table('users_address')
            ->orderBy('users_address.id', 'desc')
            ->join('subdistricts_ro', 'users_address.city_id', 'subdistricts_ro.city_id')
            ->join('provinces_ro', 'users_address.province_id', 'provinces_ro.province_id')
            ->where('status', 1)
            ->select('users_address.*', 'subdistricts_ro.name as nama_kota', 'provinces_ro.name as nama_provinsi')
            ->where('user_id', auth()->user()->id)->first();

        $listProvinsi = ListProvinsi::get();
        $listKota = ListKota::get();

        $weight = 1;
        $kurir = 'jne:sicepat:anteraja';

        $client = new Client();

        $data = $client->post('https://pro.rajaongkir.com/api/cost', [
            'headers' => [
              // 'key' => 'a906fd8fc45a816184224df29f246d93'
              'key' => '437db99af91a23c64bf1bed279bc4d0f'
            ],
            'form_params' => [
                'origin' => 6312,
                'originType' => 'subdistrict',
                'destination' => $addressActive->subdistrict_id,
                'destinationType' => 'subdistrict',
                'weight' => $weight,
                'courier' => $kurir
            ]
        ]);

        $ongkir = json_decode($data->getBody())->rajaongkir->results;
        // dd($ongkir);

        $jne = [
            'code' => $ongkir[0]->code,
            'cost' => $ongkir[0]->costs[0]->cost[0]
        ];
        $sicepat = [
            'code' => $ongkir[1]->code,
            'cost' => $ongkir[1]->costs[1]->cost[0]
        ];
        $anteraja = [
            'code' => $ongkir[2]->code,
            'cost' => $ongkir[0]->costs[0]->cost[0]
        ];
        // dd($request->inv);

        return view('Frontend.transaksi.index', [
            'transaksi' => $inv,
            'detail_transaksi' => $detailTransaksi,
            'channel_pembayaran' => $res,
            'address_active' => $addressActive,
            'address' => $address,
            'list_provinsi' => $listProvinsi,
            'list_kota' => $listKota,
            'sicepat' => $sicepat,
            'jne' => $jne,
            'anteraja' => $anteraja
        ]);
    }

    public function createInv(Request $request)
    {
        dd("CEK");
        $carts = DB::table("carts")->where("user_id", auth()->user()->id)->get();
        $subTotal = 0;

        $user_id = auth()->user()->id;
        $level = DB::table('levels')->where('id', $user_id)->first();
        $diskon = 0;
        $jenisInv = 'pembelian';
        $noInv = 'AOY/INV/'.$user_id.time();
        $totalHarga = 0;

        // return response()->json($level);

        DB::beginTransaction();
        try {

            $collectionProduk = collect();

            foreach($carts as $cart)
            {
                // dd($cart->produk_id);
                $produk = DB::table('produks')->where('id', $cart->produk_id)->first();
                $totalHargaProduk = $produk->harga*$cart->qty;
                $totalHarga += $totalHargaProduk;
                
                if($level){
                    if ($level->tipe_potongan === 'fix') {
                        // potong tiap produk
                        $potonganProduk = $level->potongan_harga*$cart->qty;
                        $diskon += $potonganProduk;
                        $subTotal += $totalHargaProduk - $potonganProduk;
                    } else {
                        $nilai = ($level->potongan_harga/100)*$produk->harga;
                        $potonganProduk = $nilai*$cart->qty;

                        $diskon += $potonganProduk;
                        $subTotal += $totalHarga - $potonganProduk;
                    }
                }else{
                    $potonganProduk = 0;
                    $subTotal = $totalHarga;
                }


                $cekInv = Transaksi::where('no_inv', $noInv)->first();
                if ($cekInv) {
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
                } else {
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

            // dd($noInv, "CEK");

            DB::commit();

            return redirect()->route("proses-transaksi", ['inv' => $noInv]) ;


        } catch (Exception $th) {
            DB::rollBack();
            return redirect()->back();
        }


    }

    public function prosesInv(Request $request)
    {
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


        if ($validasi->fails()) {
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
        // return response()->json("OK CEK 01");

        DB::beginTransaction();

        try {

            $inv = Transaksi::where('no_inv', $request->no_inv)->first();
            $user = DB::table('users')->find($inv->user_id);
            $detailTransaksi = DB::table('detail_transaksis')
                            ->where('detail_transaksis.transaksi_id', $inv->id)
                            ->join('produks', 'detail_transaksis.produk_id', 'produks.id')
                            ->get();

            $total_pembayaran = (int)$inv->total_harga_barang+(int)$request->biaya_pengiriman+(int)$request->biaya_admin;

            $apiKey       = env('TRIPAY_API_KEY');
            $privateKey   = env('TRIPAY_PRIVAT_KEY');
            $merchantCode = env("TRIPAY_MERCHENT");
            $merchantRef  = $request->no_inv;
            $amount       = $total_pembayaran-(int)$request->biaya_admin; // diambil biaya admin karena sudah di tambahkan otomatis oleh tripay
            $metode_pembayaran = $request->metode_pembayaran;
            $biaya_pengiriman = $request->biaya_pengiriman;

            $data = [
                'method'         => $metode_pembayaran,
                'merchant_ref'   => $merchantRef,
                'amount'         => $amount,
                'customer_name'  => $user->name,
                'customer_email' => $user->email,
                'customer_phone' => '081234567890',
                'order_items'    => [
                    [
                        'sku'         => $detailTransaksi[0]->slug,
                        'name'        => $detailTransaksi[0]->nama,
                        'price'       => $amount,
                        'quantity'    => 1,
                        'product_url' => 'https://tokokamu.com/product/nama-produk-1',
                        'image_url'   => 'https://tokokamu.com/product/nama-produk-1.jpg',
                    ],
                ],
                'return_url'   => url('/'),
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

            $userAddress = DB::table('users_address')->find($request->address_id);

            // return response()->json($userAddress);

            $transaksi = Transaksi::where('no_inv', $merchantRef)->update([
                'user_id' => auth()->user()->id,
                'no_inv' => $merchantRef,
                'jenis_inv' => 'pembelian',
                'metode_pembayaran' => $metode_pembayaran,
                'biaya_pengiriman' => $biaya_pengiriman,
                'sub_total' => $total_pembayaran,
                'status' => $res->data->status,
                'payment_name' => $res->data->payment_name,
                'fee_customer' => $res->data->fee_customer,
                'expired_time' => $res->data->expired_time,
                'checkout_url' => $res->data->checkout_url,
                'pay_code' => $res->data->pay_code,
                'admin_pembayaran' => $res->data->fee_merchant,
                'payment_at' => null,
                'reference' => $res->data->reference,
                'city_id' => $userAddress->city_id,
                'province_id' => $userAddress->province_id,
                'subdistrict_id' => $userAddress->subdistrict_id,
                'metode_pengiriman' => $request->metode_pengiriman
            ]);

            $inv = Transaksi::where('no_inv', $request->no_inv)->first();
            $detailTransaksi = DetailTransaksi::where('transaksi_id', $inv->id)->get();
            foreach ($detailTransaksi as $item) {
                $cartUser = Cart::where('user_id', $inv->user_id)->where('produk_id', $item->produk_id)->first();
                if ($cartUser) {
                    if ($item->qty >= $cartUser->qty) {
                        $cartUser->delete();
                    } else {
                        $qty = $cartUser->qty-$item->qty;
                        $cartUser->update('qty', $qty);
                    }
                }
            }

            $notifkasi = Notification::create([
                'user_uuid' => auth()->user()->uuid,
                'title' => 'Selesaikan pembayan anda',
                'short_body' => 'klik untuk melakukan pembayaran',
                'cta' => route('transaksi-unpaid')."?inv=".$request->no_inv,

            ]);

            DB::table("carts")->where("user_id", auth()->user()->id)->delete();

            DB::commit();

            return response()->json($inv);

        } catch (Exception $th) {
            DB::rollBack();
            return response()->json("GAGAL", 422);
        }
    }

    public function unpaid(Request $request)
    {
        if (!$request->inv) {
            return redirect('/');
        }

        $inv = $request->inv;
        $apiKey       = env('TRIPAY_API_KEY');

        $transaksi = Transaksi::where('no_inv', $inv)->first();

        if ($transaksi->status !== 'UNPAID') {
            return redirect()->route('transaksi-detail', 'inv='.$transaksi->no_inv);
        }

        try {
            $client = new Client();
            $result = $client->request('get', env("TRIPAY_URL").'transaction/detail?reference='.$transaksi->reference, [
                'headers' => [
                            'Authorization' => "Bearer " . $apiKey,
                    ],
            ]);

            $res = json_decode($result->getBody());
            setlocale(LC_ALL, 'IND');
            // $time = Carbon::createFromTimestamp("1676994526")->formatLocalized('%A %d %B %Y');
            // dd($res->data);

            return view('Frontend.transaksi.menunggu', [
                'item' => $res->data,
                "transaksi" => $transaksi
            ]);
        } catch (BadResponseException $e) {
            return redirect()->back()->with('info', 'Transaksi tidak ditemukan');
        }
    }

    public function rincian(Request $request)
    {
        if (!$request->inv) {
            return redirect('/');
        }

        $transaksi = Transaksi::where('no_inv', $request->inv)->where('user_id', auth()->user()->id)->with('provinsi', 'kota', 'kecamatan')->first();
        $detailTransaksi = DetailTransaksi::where('transaksi_id', $transaksi->id)->with('produk')->get();

        if (!$transaksi) {
            return redirect('/');
        }
        // if ($transaksi->status === 'UNPAID') {
        //     return redirect()->route('transaksi-unpaid', 'inv='.$transaksi->no_inv);
        // }

        $resi = null;
        if ($transaksi->resi) {
            try {
                $client = new Client();
                // return $orders->resi;
                $data = $client->post('https://pro.rajaongkir.com/api/waybill', [
                    'headers' => [
                      // 'key' => 'a906fd8fc45a816184224df29f246d93'
                      'key' => '437db99af91a23c64bf1bed279bc4d0f'
                    ],
                    'form_params' => [
                        'waybill' => $transaksi->resi,
                        'courier' => $transaksi->metode_pengiriman
                    ]
                ]);
                $response = json_decode($data->getBody()); //->getContents();
                $resi = $response->rajaongkir;
                // dd($resi);
            } catch (BadResponseException $e) {
                $resi = null;
            }
        }

        // dd($transaksi);

        return view('Frontend.transaksi.rincian', [
            'transaksi' => $transaksi,
            'detail_transaksi' => $detailTransaksi,
            'resi' => $resi,
        ]);
    }

    public function konfirmasi(Request $request)
    {
        if (!$request->inv || !$request->reference) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        if ($request->status === "1" || $request->status === 1) {
            $transaksi = DB::table('transaksis')->where('no_inv', $request->inv)->where('reference', $request->reference)->update([
                'status' => 'selesai',
                'updated_at' => now()
            ]);

            return redirect()->back()->with('success', 'Berhasil konfirmasi pesanan');
        }

        if ($request->status === auth()->user()->uuid) {
            $transaksi = DB::table('transaksis')->where('no_inv', $request->inv)->where('reference', $request->reference)->update([
                'status' => 'komplain',
                'updated_at' => now()
            ]);
            return redirect()->back()->with('success', 'Berhasil komplain pesanan');
        }

        return redirect()->back()->with('error', 'Data tidak ditemukan');
    }
}
