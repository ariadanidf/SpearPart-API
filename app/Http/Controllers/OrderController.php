<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Track;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Exception;
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
                $orderData['id_order'] = $orderData['id_order'];
                
                return response()->json([
                    'code' => 200,
                    'message' => 'Success',
                    'data' => $orderData
                ]);
            } else {
                return response()->json([
                    'code' => 404,
                    'message' => 'Not Found'
                ]);
            }
        } catch (Exception $error) {
            return response()->json([
                'code' => 500,
                'message' => 'Internal Server Error: ' . $error->getMessage()
            ]);
        }
    }

    //update harga -> sonia
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
                    $existingData->total_harga = $existingData->harga_barang + $existingData->harga_ongkir;
                    $existingData->save();
                    $savedData[] = $existingData;
                }
            }

            $response = Http::get('http://127.0.0.1:8001/api/pengiriman/data_pengiriman');
            $responseData = $response->json();
        
        if ($response->status() === 200) {
            $savedData = [];
    
            foreach ($responseData['data'] as $item) {
                // Periksa apakah id_order sudah ada di database
                $existingData = Order::where('id_order', $item['id_order'])->first();
    
                if ($existingData) {
                    // Jika id_order ada, lakukan pembaruan harga_ongkir
                    $existingData->no_resi = $item['no_resi'];
                    $existingData->save();
                    $savedData[] = $existingData;
                }
            }

            return response()->json([
                'code' => 200,
                'message' => 'Success',
                'data' => $savedData
            ]);
        } else {
            return response()->json([
                'code' => 400,
                'message' => 'Bad Request'
            ]);
        }
    }
}
    //lacak -> dani
    public function lacak(Request $request, $id_order)
    {
        $response = Http::get('http://127.0.0.1:8001/api/pengiriman/lacakOrder/'. $id_order);
        $responseData = json_decode($response->body());
    
        if ($response->status() === 200) {
            if (!empty($responseData->data)) {
                $savedData = [];
                foreach ($responseData->data as $item) {
                    // Periksa apakah id_order sudah ada di database
                    $existingData = Track::where('id_order', $item->id_order)->first();
                    
                    if (!$existingData) {
                        // Jika id_order tidak ada, simpan ke database
                        $data = Track::create([
                        'id_order' => $item->id_order, 
                        'no_resi' => $item->no_resi,
                        'estimasi_waktu' => $item->estimasi_waktu,
                        'status' => $item->status,
                        'lokasi' => $item->lokasi,
                        'konfirmasi_pengiriman' => $item->konfirmasi_pengiriman
                        ]);
                        $savedData[] = $data;
                    
                        return response()->json([
                        'code' => 200,
                        'message' => 'Success',
                        'data' => $savedData
                    ]);
                    }
                    else {
                        $savedData = Track::select('no_resi',
                        'id_order',
                        'estimasi_waktu',
                        'status',
                        'lokasi',
                        'konfirmasi_pengiriman')->get();
                        return response()->json([
                            'code' => 200,
                            'message' => 'Success',
                            'data' => $savedData
                        ]);
                    }
                } 
            } 
            
            else {
                return response()->json([
                    'code' => 400,
                    'message' => 'Bad Request'
                ]);
            }
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

    public function show($id_order)
    {
        $order = Order::find($id_order);
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
