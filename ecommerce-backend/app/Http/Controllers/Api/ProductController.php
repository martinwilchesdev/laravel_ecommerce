<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        // creacion de una consulta base
        $query = Product::query()->with(['category']); // uso de eager loading para cargar las categorias

        // filtro de busqueda por nombre o descripcion del producto
        if ($request->has('search') && $request->search !== '') {
            $query->where(function ($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->search . '%')
                    ->orWhere('descripcion', 'like', '%' . $request->search . '%');
            });
        }

        // filtro por categoria
        if ($request->has('categoria_id') && $request->category_id !== null) {
            $query->where('categoria_id', $request->category_id);
        }

        // filtro por rango de precios
        if ($request->has('precio_minimo') && $request->min_price !== null) {
            $query->where('precio', '>=', $request->precio_minimo);
        }

        if ($request->has('precio_maximo') && $request->max_price !== null) {
            $query->where('precio', '<=', $request->precio_maximo);
        }


        // consultar todos los productos y retornarlos al cliente
        return response()->json($query->paginate(10));
    }

    public function show($id): JsonResponse
    {
        // obtner un producto en especifico a traves de su id y retornarlo al cliente
        $product = Product::findOrFail($id);
        return response()->json($product);
    }
}
