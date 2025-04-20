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
        return response()->json(Product::all());
    }
}
