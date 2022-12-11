<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'pay_code', 'no_inv', 'jenis_inv', 'metode_pembayaran', 'biaya_pengiriman', 'admin_pembayaran', 'payment_at', 'sub_total', 'status', 'checkout_url', 'expired_time', 'fee_customer', 'payment_name'
    ];
}
