<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        $items = Gallery::orderBy("id", "desc")->get();

        return view("Frontend.media.index", [
            'items' => $items
        ]);
    }
}
