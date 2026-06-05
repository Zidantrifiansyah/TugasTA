<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'nama_pembeli',
        'email',
        'no_telepon',
        'alamat',
        'catatan',
        'total_harga',
        'status',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
