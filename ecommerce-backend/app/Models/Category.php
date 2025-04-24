<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $table = 'categorias';

    public function product(): HasMany {
        return $this->hasMany(Product::class);
    }
}
