<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index(): JsonResponse
    {
        // consultar todos los productos y retornarlos al cliente
        return response()->json(Product::all());
    }

    public function show($id): JsonResponse
    {
        // obtner un producto en especifico a traves de su id y retornarlo al cliente
        $product = Product::findOrFail($id);
        return response()->json($product);
    }
}
