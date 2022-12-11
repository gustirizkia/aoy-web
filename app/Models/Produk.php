<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Produk extends Model
{
    use HasFactory;

    protected $appends = ['thumbnail'];

    public function getThumbnailAttribute(){
        $data = DB::table('product_image')->where('product_id', $this->id)->where('is_thumbnail', 1)->where('status', 1)->orderBy('id', 'desc')->first();
        if($data){
            return $data;
        }

        $data = DB::table('product_image')->where('product_id', $this->id)->where('status', 1)->first();

        return $data;
    }

    public function image(){
        return $this->hasMany('App\Models\ImageProduk', 'product_id');
    }
}
