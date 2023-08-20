<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\AdminTransaksisController;
use App\Http\Controllers\AlamatController;
use App\Http\Controllers\Dashboard\AkunController;
use App\Http\Controllers\Dashboard\ProdukController as DashboardProdukController;
use App\Http\Controllers\Dashboard\StoreSettingController;
use App\Http\Controllers\Dashboard\TransaksiController as DashboardTransaksiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\DetailProductController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\MemberController;
use App\Http\Controllers\Front\ProdukController;
use App\Http\Controllers\Front\SellerController;
use App\Http\Controllers\Front\TransaksiController;
use App\Http\Controllers\Front\UserController;
use App\Http\Controllers\OngkirController;
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
Route::get('member/{username}', [HomeController::class, 'detailMember'])->name('detailMember');
Route::get('member', [MemberController::class, 'index'])->name('member-index');
Route::get('getMember', [MemberController::class, 'getMember'])->name('getMember');
Route::get('member-filter', [SellerController::class, 'filter'])->name('member-filter');
Route::get('getNotif', [UserController::class, 'getNotif'])->name('getNotif')->middleware('auth');

Route::get('produk', [ProdukController::class, 'index'])->name('produk');
Route::get('/produk/{slug}', [DetailProductController::class, 'index'])->name('detail-produk');
Route::post('orderLangsung', [DetailProductController::class, 'orderLangsung'])->name('orderLangsung')->middleware('auth');
Route::get('keranjang', [CartController::class, 'index'])->name('keranjang')->middleware('auth');
Route::get('/transaksi-proses', [TransaksiController::class, 'index'])->name('proses-transaksi')->middleware('auth');
Route::post('/createInv', [TransaksiController::class, 'createInv'])->name('createInv');
Route::post('/transaksi-pending', [TransaksiController::class, 'menungguPembayaran'])->name('transaksi-pending')->middleware('auth');
Route::get('/transaksi-unpaid', [TransaksiController::class, 'unpaid'])->name('transaksi-unpaid')->middleware('auth');
Route::get('/transaksi-detail', [TransaksiController::class, 'rincian'])->name('transaksi-detail');
Route::get('/konfirmasi', [TransaksiController::class, 'konfirmasi'])->name('konfirmasi');
Route::post('/add-cart', [DetailProductController::class, 'addCart'])->name('add-cart');

Route::post('tambah-alamat', [UserController::class, 'tambahAlamat'])->name('tambah-alamat')->middleware('auth');
Route::get('kecamatan-rajaongkir', [OngkirController::class, 'getSubdistrict'])->name('kecamatan');
Route::get('change-active-alamat', [AlamatController::class, 'changeActive'])->name('changeActive')->middleware('auth');
Route::post('viewOngkirProduct', [OngkirController::class, 'viewOngkirProduct'])->name('viewOngkirProduct')->middleware('auth');

Route::prefix('dashboard')->middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/produk-saya', [DashboardProdukController::class, 'index'])->name('produk-saya');
    Route::get('/transaksi', [DashboardTransaksiController::class, 'index'])->name('dashboard-transaksi');
    Route::get('/transaksi-buat-invoice', [DashboardTransaksiController::class, 'create'])->name('dashboard-transaksi-create');
    Route::post('/invPenjualan', [DashboardTransaksiController::class, 'invPenjualan'])->name('invPenjualan');
    Route::get('store-setting', [StoreSettingController::class, 'index'])->name('store-setting');
    Route::post('store-setting', [StoreSettingController::class, 'store'])->name('insert-store-setting');
    Route::post('upload-gallery-image', [StoreSettingController::class, 'uploadImage'])->name('upload-image-gallery');
    Route::get('delete-image', [StoreSettingController::class, 'deleteImage'])->name('deleteImage');

    Route::get('akun-saya', [AkunController::class, 'index'])->name('akun-saya');
    Route::get('profile', [AkunController::class, 'afterRegister'])->name('afterRegister');
    Route::post('updateProfile', [AkunController::class, 'updateProfile'])->name('updateProfile');
    Route::get('akun-saya/edit-alamat/{id}', [AkunController::class, 'editAlamat'])->name('edit-alamat-dashboard');
});

Route::get('admin', [AdminDashboardController::class, 'index']);
Route::post('updateResi/{id}', [AdminTransaksisController::class, 'updateResi'])->name('updateResi');

require __DIR__.'/auth.php';
