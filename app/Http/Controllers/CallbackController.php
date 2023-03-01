<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\ProdukSaya;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class CallbackController extends Controller
{

    public function handle(Request $request)
    {
        $privateKey = env('TRIPAY_PRIVAT_KEY');
        $callbackSignature = $request->server('HTTP_X_CALLBACK_SIGNATURE');
        $json = $request->getContent();
        $signature = hash_hmac('sha256', $json, $privateKey);

        if ($signature !== (string) $callbackSignature) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid signature',
                'callbackSignature' => $callbackSignature,
                'signature' => $signature,
                'json' => $json,
                'privateKey' => $privateKey
            ], 422);
        }

        $transaksi = Transaksi::where('reference', $request->reference)->first();
        if(!$transaksi){
            return response()->json([
                'success' => false,
                'message' => 'transaksi not found'
            ], 422);
        }

        $status = $request->status;

        switch ($status) {
                case 'PAID':
                    $transaksi->update(['status' => 'PAID', 'payment_at' => now()]);
                    break;

                case 'EXPIRED':
                    $transaksi->update(['status' => 'EXPIRED']);
                    break;

                case 'FAILED':
                    $transaksi->update(['status' => 'FAILED']);
                    break;

                default:
                    return response()->json([
                        'success' => false,
                        'message' => 'Unrecognized payment status',
                    ], 422);
        }

        $transaksi = Transaksi::where('reference', $request->reference)->first();

        if($status === 'PAID'){
            $detailTransaksi = DetailTransaksi::where('transaksi_id', $transaksi->id)->get();
            foreach($detailTransaksi as $item){
                $cek = ProdukSaya::where('produk_id', $item->produk_id)->where('user_id', $transaksi->user_id)->first();
                if($cek){
                    $qty = $cek->qty+$item->qty;
                    $cek->update(['qty' => $qty]);
                }else{
                    $insert = DB::table('produk_sayas')->insertGetId([
                        'produk_id' => $item->produk_id,
                        'qty' => $item->qty,
                        'user_id' => $transaksi->user_id,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }

            return response()->json([
                'success' => true,
                'transaksi' => $transaksi,
                'detail_transaksi' => $detailTransaksi
            ]);
        }

        return response()->json([
            'success' => true,
            'transaksi' => $transaksi
        ]);

    }
}
