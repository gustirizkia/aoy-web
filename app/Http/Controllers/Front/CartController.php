<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Produk;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class CartController extends Controller
{
    public function index(Request $request)
    {
        if($request->session()->get('current_page') !== 'keranjang') {
            $request->session()->put('current_page', 'keranjang');
            $request->session()->put('prev', URL::previous());
        }

        $cart = Cart::with('produk')->where('user_id', auth()->user()->id)->get()->groupBy('produk_id')->values();
        $potongan = DB::table('levels')->where('id', auth()->user()->level)->first();
        $alamat = DB::table("users_address")->where("user_id", auth()->user()->id)->exists();

        return view('Frontend.keranjang', [
            'produks' => $cart,
            'level' => $potongan,
            'alamat' => $alamat
        ]);
    }
}
