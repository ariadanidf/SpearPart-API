<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use App\Helpers\ApiFormatter;

class StockController extends Controller
{
    public function index()
    {
        $stok = Stock::all();
        if($stok -> count() > 0){
            return response()->json([
                'code' => "200",
                'message' => "Success",
                'data' => $stok
            ]);
        }
        else{
            return response()->json([
                'code' => "404",
                'message' => "Not Found"
            ]);
        }
    }

    //daniel
    public function show($kode_barang)
    {
        $data = Stock::where('kode_barang', '=', $kode_barang)->get();

        if ($data) {
            return ApiFormatter::createApi(200, 'Success', $data);
        } else {
            return ApiFormatter::createApi(400, 'Bad Request');
        }
    }
    
    public function cekStok(Request $request)
     {
         $response = Http::get('http://127.0.0.1:8002/api/stok');
         $responseData = json_decode($response->body());
     
         if ($response->status() === 200) {
             if (!empty($responseData->data)) {
                 $savedData = [];
                 foreach ($responseData->data as $item) {
                     $existingData = Stock::where('kode_barang', $item->kode_barang)->first();
                     if (!$existingData) {
                         $data = Stock::create([
                            'kode_barang' => $item->kode_barang, 
                            'nama_barang' => $item->nama_barang,
                            'stok' => $item->stok,
                            'quality' => $item->quality
                            ]);
                         $savedData[] = $data;
                     }
                 }
     
                 return ApiFormatter::createApi(200, 'Success', $responseData);
             } else {
                 return ApiFormatter::createApi(400, 'Bad Request');
             }
         } else {
             return ApiFormatter::createApi(400, 'Bad Request');
         }
     }

    //agung
    public function update(Request $request, $kode_barang)
    {
        try {
            $validatedData = $request->validate([
                'nama_barang' => 'required|string',
                'stok' => 'required|integer',
                'quality' => 'required|string',
            ]);
    
            $data = Stock::where('kode_barang', $kode_barang)->first();
            if (!$data) {
                return ApiFormatter::createApi(404, 'Not Found');
            }
    
            $data->update($validatedData);
    
            return ApiFormatter::createApi(200, 'Barang updated successfully', $data);
        } catch (Exception $e) {
            \Log::error($e);  // ini akan mencatat pengecualian ke log Laravel
            return ApiFormatter::createApi(500, 'Internal Server Error: ' . $e->getMessage());
        }    
        }

    // public function updatestok(Request $request, $id)
    // {
    //     try {
    //         $request->validate([
    //             'kode_barang' => 'required',
    //             'nama_barang' => 'required',
    //             'stok' => 'required',
    //             'quality' => 'required',
    //         ]);


    //         $cekstok = Stock::findOrFail($id);

    //         $logistik->update([
    //             'kode_barang' => $request->kode_barang,
    //             'nama_barang' => $request->nama_barang,
    //             'stok' => $request->stok,
    //             'quality' => $request->quality,
    //         ]);

    //         $data = cekstok::where('kode_barang', '=', $cekstok->id)->get();

    //         if ($data) {
    //             return ApiFormatter::createApi(200, 'Success', $data);
    //         } else {
    //             return ApiFormatter::createApi(400, 'Failed');
    //         }
    //     } catch (Exception $error) {
    //         return ApiFormatter::createApi(400, 'Failed');
    //     }
    // }

}