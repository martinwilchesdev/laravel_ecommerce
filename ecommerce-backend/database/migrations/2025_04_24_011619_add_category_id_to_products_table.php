<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            // añadir la columna `category_id` a la tabla `products`
            $table->foreignId('categoria_id')->nullable()->constrained()->onDelete('set null');
        });
    }
};
