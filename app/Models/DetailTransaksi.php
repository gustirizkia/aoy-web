<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'produk_id', 'transaksi_id', 'qty', 'harga', 'potong'
    ];

    public function produk(){
        return $this->belongsTo('App\Models\Produk', 'produk_id');
    }

    public function transaksi(){
        return $this->belongsTo('App\Models\Transaksi');
    }
}
