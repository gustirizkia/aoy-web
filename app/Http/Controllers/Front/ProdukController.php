<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $data = Produk::orderBy('id', 'desc')->get();
        return view('Frontend.produk', [
            'items' => $data
        ]);
    }
}
