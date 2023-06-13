<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function show($id)
    {
        $data = Stock::where('kode_barang', '=', $id)->get();

        if ($data) {
            return ApiFormatter::createApi(200, 'Success', $data);
        } else {
            return ApiFormatter::createApi(400, 'Bad Request');
        }
    }

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
