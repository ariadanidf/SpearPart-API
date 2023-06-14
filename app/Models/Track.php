<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'id_lacak';
    protected $fillable = [
        'no_resi',
        'id_order',
        'estimasi_waktu',
        'status',
        'lokasi',
        'konfirmasi_pengiriman',
    ];

    protected $table = 'tracks';

    // protected $primaryKey = '';

    public $incrementing = true;
}
