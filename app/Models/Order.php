<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_customer',
        'nama_barang',
        'alamat_penerima',
        'order_date',
        'jenis_pengiriman',
        'berat_barang',
        'status',
        'harga_barang',
        'harga_ongkir',
        'total_harga',
        'no_resi',

    ];

    // Nama tabel yang digunakan oleh model
    protected $table = 'orders';

    // Kolom yang dianggap sebagai kunci utama (secara default, Eloquent mengasumsikan kolom 'id' sebagai kunci utama)
    protected $primaryKey = 'id_order';

    // Menyatakan bahwa kunci utama adalah inkremen
    public $incrementing = true;

}
