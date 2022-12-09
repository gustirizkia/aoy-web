<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        return view('Frontend.transaksi.index');
    }

    public function menungguPembayaran(Request $request)
    {
        return view('Frontend.transaksi.menunggu');
    }

    public function rincian(Request $request)
    {
        return view('Frontend.transaksi.rincian');
    }
}
