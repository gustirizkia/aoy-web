<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('no_inv');
            $table->string('jenis_inv');
            $table->string('metode_pembayaran');
            $table->string('biaya_pengiriman');
            $table->bigInteger('admin_pembayaran');
            $table->dateTime('payment_at')->nullable();
            $table->char('sub_total', 50);
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksis');
    }
}
