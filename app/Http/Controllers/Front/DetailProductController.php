<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\ImageProduk;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DetailProductController extends Controller
{
    public function index(Request $request, $slug){
        $data = Produk::where('slug', $slug)->first();
        if(!$data){
            abort(404);
        }

        // $test = \App\Models\Cart::where('user_id', Auth::user()->id)->sum('qty');
        // dd($test);


        $image = ImageProduk::where('product_id', $data->id)->get();
        // return response()->json([$data, $image]);

        return view('Frontend.detail-produk', [
            'produk' => $data,
            'images' => $image
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
