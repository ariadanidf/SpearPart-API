<?php

namespace App\Http\Controllers;

use App\Models\Price;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PriceController extends Controller
{
    public function checkPrice($id_produk, $qty, $id_customer)
    {
        $product = Price::find($id_produk);

        if (!$product) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found'
            ]);
        }
        else
        {
            $harga_barang = $product->harga_barang;
            $harga_ongkir = null; // dari pihak shipping
            $harga_total = $harga_barang + $harga_ongkir;
            
            return response()->json([
                'code' => 200,
                'message' => 'Success',
                'data' => $product
        ]);
        }   
    }
}
