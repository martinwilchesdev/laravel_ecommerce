<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $table = 'ordenes';

    protected $fillable = [
        'estado',
        'total',
        'user_id'
    ];

    // una orden pertenece a un usuario
    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }

    // una orden tiene muchos items
    public function items(): HasMany {
        return $this->hasMany(OrderItem::class, 'orden_id');
    }
}
