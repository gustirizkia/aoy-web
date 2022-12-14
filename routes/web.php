<?php

use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\DetailProductController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\ProdukController;
use App\Http\Controllers\Front\TransaksiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index']);
Route::get('produk', [ProdukController::class, 'index'])->name('produk');
Route::get('/produk/{slug}', [DetailProductController::class, 'index'])->name('detail-produk');
Route::get('keranjang', [CartController::class, 'index'])->name('keranjang')->middleware('auth');
Route::post('/transaksi-proses', [TransaksiController::class, 'index'])->name('proses-transaksi')->middleware('auth');
Route::get('/transaksi-pending', [TransaksiController::class, 'menungguPembayaran'])->name('transaksi-pending');
Route::get('/transaksi-detail', [TransaksiController::class, 'rincian'])->name('transaksi-detail');
Route::post('/add-cart', [DetailProductController::class, 'addCart'])->name('add-cart');

Route::get('/dashboard', function () {
    return view('welcome');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
