<?php

namespace App\Models;

class Motor extends Vehicle
{
    protected $fillable = [
        'tahun_keluaran', 'warna', 'harga', 'tipe', 'stok', 'detail'
    ];
}