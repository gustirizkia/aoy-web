<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukSaya extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function produk(){
        return $this->belongsTo('App\Models\Produk', 'produk_id');
    }
}
