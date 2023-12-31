<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\StockController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


//order
Route::get('pemesanan', [OrderController::class,'index']);

Route::post('pemesanan', [OrderController::class,'ordering']);

Route::get('updateOrder', [OrderController::class,'updateOrder']);

Route::get('pemesanan/{id_order}', [OrderController::class,'show']);

Route::get('lacak/{id_order}', [OrderController::class,'lacak']);

//stock
Route::get('stok/show/', [StockController::class, 'index']);

Route::get('stok/show/{kode_barang}', [StockController::class, 'show']);

Route::get('cekStok', [StockController::class, 'cekStok']);

Route::post('cekstok/barang/{kode_barang}', [StockController::class, 'update']);
