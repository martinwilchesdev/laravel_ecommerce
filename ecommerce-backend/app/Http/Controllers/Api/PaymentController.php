<?php

namespace App\Http\Controllers\Api;

use Stripe\Stripe;
use Stripe\PaymentIntent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    public function createPaymentIntent(Request $request) {
        // se estasblece la clave secreta de Stripe obtenida desde el config/services.php
        Stripe::setApiKey(config('services.stripe.secret'));

        // orden a pagar enviada en la request
        $order = $request->input('orderToPay');

        // se crea el payment intent (recibe el monto a pagar, la moneda y metadatos adicionales que podran ser accedidos posteriormente desde el webhook)
        $intent = PaymentIntent::create([
            'amount' => $order['total'] * 100, // stripe trabaja en centavos
            'currency' => 'usd',
            'metadata' => [
                'order_id' => $order['id'], // id de la orden a pagar
                'user_id' => auth()->id() // opcional para identificar el usuario
            ]
        ]);

        return response()->json([
            // se retorna la clave secreta especifica para el cliente (token temporal que identifica de forma segura el payment intent en el frontend)
            // se usa para completar el pago con Stripe.js
            'clientSecret' => $intent->client_secret
        ]);
    }
}
