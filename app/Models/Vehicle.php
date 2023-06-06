<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
        'tahun_keluaran', 'warna', 'harga', 'tipe', 'stok', 'detail'
    ];
}
