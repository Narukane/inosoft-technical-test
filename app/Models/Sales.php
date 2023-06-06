<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Sales extends Model
{
    protected $fillable = [
        'nama_customer', 'jumlah', 'total_harga', 'item'
    ];
}
