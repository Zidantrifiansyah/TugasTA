<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CupangProduct extends Model
{
    protected $table = 'cupang_products';

    protected $fillable = [
        'nama',
        'deskripsi',
        'varian',
        'harga',
        'stok',
        'gambar',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_id');
    }
}
