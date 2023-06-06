<?php

namespace App\Models;

class Car extends Vehicle
{
    protected $fillable = [
        'tahun_keluaran', 'warna', 'harga', 'tipe', 'stok', 'detail'
    ];
}