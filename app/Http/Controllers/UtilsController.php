<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UtilsController extends Controller
{
    public function generateUuid($table)
    {
        $string = Str::random(13);
        $cek = DB::table($table)->where('uuid', $string)->first();
        if($cek)
        {
         return   $this->generateUuid($table);
        }else{
            return $string;
        }
    }
}
