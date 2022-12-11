<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\ImageProduk;
use App\Models\Produk;
use Illuminate\Http\Request;

class DetailProductController extends Controller
{
    public function index(Request $request, $slug){
        $data = Produk::where('slug', $slug)->first();
        if(!$data){
            abort(404);
        }


        $image = ImageProduk::where('product_id', $data->id)->get();
        // return response()->json([$data, $image]);

        return view('Frontend.detail-produk', [
            'produk' => $data,
            'images' => $image
        ]);
    }
}
