<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class CartController extends Controller
{
    public function index(Request $request){
        if($request->session()->get('current_page') !== 'keranjang'){
            $request->session()->put('current_page', 'keranjang');
            $request->session()->put('prev', URL::previous());
        }


        return view('Frontend.keranjang');
    }
}
