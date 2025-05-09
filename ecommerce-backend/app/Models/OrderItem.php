<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $table = 'orden_items';

    protected $fillable = [
        'cantidad',
        'precio',
        'subtotal',
        'orden_id',
        'producto_id'
    ];

    // un item pertenece a una orden
    public function order() : BelongsTo {
        return $this->belongsTo(Order::class, 'orden_id');
    }

    // un item pertenece a un producto
    public function product() {
        return $this->belongsTo(Product::class, 'producto_id');
    }
}
