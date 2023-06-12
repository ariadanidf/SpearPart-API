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


Route::get('pemesanan', [OrderController::class,'index']);

Route::post('pemesanan/ordering', [OrderController::class,'ordering']);

Route::get('pemesanan/updateOrder', [OrderController::class,'updateOrder']);

Route::get('pemesanan/{id}', [OrderController::class,'show']);

Route::get('/price/{id_produk}/{qty}/{id_customer}', [PriceController::class, 'checkPrice']);
