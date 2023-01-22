<?php

use App\Http\Controllers\CallbackController;
use App\Http\Controllers\Front\TransaksiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\TransaksiController as DashboardTransaksiController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/createInv', [TransaksiController::class, 'createInv'])->name('api-createInv');
Route::post('/invPenjualan', [DashboardTransaksiController::class, 'invPenjualan'])->name('invPenjualan');
Route::post('callback-tripay', [CallbackController::class, 'handle']);
