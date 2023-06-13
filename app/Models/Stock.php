<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    protected $table = 'stocks';
    protected $primaryKey = 'kode_barang';
    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'stok',
        'quality',
    ];

    protected $hidden = [];
}
