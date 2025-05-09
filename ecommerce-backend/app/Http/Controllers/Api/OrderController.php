<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function store(Request $request) {
        $request->validate([
            // requerido, debe ser de tipo array y debe tener al menos un elemento
            'items' => 'required|array|min:1',
            // requerido, para cada elemento dentro de `items`, el campo `product_id` es obligatorio y debe existir en la tabla productos
            'items.*.producto_id' => 'required|exists:productos,id',
            // requerido, debe ser un numero entero y ser mayor o igual a 1
            'items.*.cantidad' => 'required|integer|min:1'
        ]);

        // envolver el proceso en una transaccion para asegurarse que las operaciones se ejecuten de forma atomica (todas se ejecutan o ninguna)
        DB::beginTransaction();

        try {
            // crear la orden
            $order = Order::create([
                'user_id' => 1,
                'total' => 0
            ]);

            $total = 0;

            // se crea cada item de la orden
            foreach($request->items as $item) {
                $product = Product::findOrFail($item['producto_id']);
                $subtotal = $product->precio * $item['cantidad'];
                $total += $subtotal;

                // se crea el item de la orden asociado al producto
                OrderItem::create([
                    'cantidad' => $item['cantidad'],
                    'producto_id' => $product->id,
                    'precio' => $product->precio, // precio del producto por unidad
                    'orden_id' => $order->id,
                    'subtotal' => $subtotal
                ]);
            }

            // se actualiza el total de la orden
            $order->update(['total' => $total]);

            // se confirma el proceso realizado dentro de la transaccion
            DB::commit();

            return response()->json([
                'message' => 'Orden creada exitosamente',
                // cargar las relaciones asociadas al modelo
                'order' => $order->load('items.product') // items => los elementos de la orden, product => relacion de cada item de la orden con su producto
            ]);
        } catch(\Exception $e) {
            // realizar un rollback deshaciendo todo lo que se hizo desde beginTransaction()
            DB::rollBack();
            return response()->json([
                'message' => 'Hubo un error al procesar la orden',
                'error' => $e->getMessage()
            ],  500);
        }
    }
}
