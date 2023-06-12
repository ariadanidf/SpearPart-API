<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function show($id)
    {
        $data = cekstok::where('kode_barang', '=', $id)->get();

        if ($data) {
            return ApiFormatter::createApi(200, 'Success', $data);
        } else {
            return ApiFormatter::createApi(400, 'Failed');
        }
    }

    public function updatestok(Request $request, $id)
    {
        try {
            $request->validate([
                'kode_barang' => 'required',
                'nama_barang' => 'required',
                'stok' => 'required',
                'quality' => 'required',
            ]);


            $cekstok = cekstok::findOrFail($id);

            $logistik->update([
                'kode_barang' => $request->kode_barang,
                'nama_barang' => $request->nama_barang,
                'stok' => $request->stok,
                'quality' => $request->quality,
            ]);

            $data = cekstok::where('kode_barang', '=', $cekstok->id)->get();

            if ($data) {
                return ApiFormatter::createApi(200, 'Success', $data);
            } else {
                return ApiFormatter::createApi(400, 'Failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi(400, 'Failed');
        }
    }

}