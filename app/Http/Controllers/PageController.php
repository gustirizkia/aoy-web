<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    public function index(Request $request, $page){


        if($request->page === "tentang"){
            $item = Page::where("page", "tentang")->firstOrFail();

        }else{
            return abort(404);
        }

        return view("Frontend.page", [
            'item' => $item
        ]);
        // $item = DB::table("pages")->where("uuid", $request->page)->find($request->page);
    }
}
