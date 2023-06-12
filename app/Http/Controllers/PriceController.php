<?php

namespace App\Http\Controllers;

use App\Models\Price;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PriceController extends Controller
{
    public function checkPrice($id_produk, $qty, $id_customer)
    {
        $product = Product::find($id_produk);

        if (!$product) {
            return response()->json([
                'error' => 'Produk tidak ditemukan'
            ], 404);
        }

        $harga_barang = $product->harga_barang;
        $harga_ongkir = null; // dari pihak shipping
        $harga_total = $harga_barang + $harga_ongkir;

        return response()->json([
            'id_produk' => $id_produk,
            'qty' => $qty,
            'id_customer' => $id_customer,
            'harga_barang' => intval($harga_barang),
            'harga_ongkir' => $harga_ongkir,
            'harga_total' => $harga_total
        ]);
    }
}
