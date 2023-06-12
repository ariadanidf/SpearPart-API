<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    //bikin order
    public function ordering(Request $request)
{
    try {
        $request->validate([
            'id_customer' => 'required',
            'nama_barang' => 'required',
            'alamat_penerima' => 'required',
            'order_date' => 'required',
            'jenis_pengiriman' => 'required',
            'berat_barang' => 'required',
            'harga_barang' => 'required'
        ]);

        $order = Order::create([
            'id_order' => $request->id_order,
            'id_customer' => $request->id_customer,
            'nama_barang' => $request->nama_barang,
            'alamat_penerima' => $request->alamat_penerima,
            'order_date' => $request->order_date,
            'jenis_pengiriman' => $request->jenis_pengiriman,
            'berat_barang' => $request->berat_barang,
            'harga_barang' => $request->harga_barang
        ]);

        if ($order) {
            $orderData = $order->toArray();
            $orderData['id_order'] = $orderData['id'];
            unset($orderData['id']);
            
            return response()->json([
                'code' => 200,
                'message' => 'Sukses',
                'data' => $orderData
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'message' => 'Kesalahan Server Internal'
            ]);
        }
    } catch (Exception $error) {
        return response()->json([
            'code' => 500,
            'message' => 'Kesalahan Server Internal'
        ]);
    }

}

    //update order
    public function updateOrder(Request $request)
    {
        $response = Http::get('http://127.0.0.1:8001/api/pesanan/data_pesanan');
        $responseData = $response->json();
    
        if ($response->status() === 200) {
            $savedData = [];
    
            foreach ($responseData['data'] as $item) {
                // Periksa apakah id_order sudah ada di database
                $existingData = Order::where('id_order', $item['id_order'])->first();
    
                if ($existingData) {
                    // Jika id_order ada, lakukan pembaruan harga_ongkir
                    $existingData->harga_ongkir = $item['harga_ongkir'];
                    $existingData->save();
                    $savedData[] = $existingData;
                }
            }
    
            return response()->json([
                'code' => 200,
                'message' => 'Sukses',
                'data' => $savedData
            ]);
        } else {
            return response()->json([
                'code' => 400,
                'message' => 'Gagal'
            ]);
        }
    }
    
    
    
    public function index()
    {
        $order = Order::all();
        if($order -> count() > 0){
            return response()->json([
                'code' => "200",
                'message' => "Success",
                'data' => $order
            ]);
        }
        else{
            return response()->json([
                'code' => "404",
                'message' => "Not Found"
            ]);
        }
    }

    public function show($id)
    {
        $order = Order::find($id);
        if($order){
        return response()->json([
            'code' => "200",
            'message' => "Success",
            'data' => $order
        ]);
    }
    else{
        return response()->json([
            'code' => "404",
            'message' => "Not Found"
        ]);
    }
    }

}
