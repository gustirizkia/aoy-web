<?php

namespace Database\Seeders;

use App\Models\Transaksi;
use Illuminate\Database\Seeder;

class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jenisInv = 'pembelian';
        $noInv = 'AOY/INV/'.time();
        Transaksi::create([
            'user_id' => 2,
            'no_inv' => $noInv,
            'jenis_inv' => $jenisInv,
            'sub_total' => 46000,
            'status' => 'selesai',
            'total_harga_barang' => 50000,
            'diskon' => 4000,
            'payment_at' => now(),
            // 'biaya_pengiriman' =>
        ]);
    }
}
