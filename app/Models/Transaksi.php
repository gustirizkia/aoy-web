<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'pay_code', 'total_harga_barang','no_inv', 'reference', 'metode_pengiriman', 'diskon', 'jenis_inv', 'metode_pembayaran', 'biaya_pengiriman', 'admin_pembayaran', 'payment_at', 'sub_total', 'status', 'checkout_url', 'expired_time', 'fee_customer', 'payment_name'
    ];


    public function detail(){
        return $this->hasMany('App\Models\DetailTransaksi', 'transaksi_id');
    }

    public function provinsi(){
        return $this->belongsTo('App\Models\ListProvinsi', 'province_id', 'province_id');
    }

    public function kota(){
        return $this->belongsTo('App\Models\ListKota', 'city_id', 'city_id');
    }

    public function kecamatan(){
        return $this->belongsTo('App\Models\ListKecamatan', 'subdistrict_id', 'subdistrict_id');
    }
}
