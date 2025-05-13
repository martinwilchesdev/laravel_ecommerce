<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class PaymentController extends Controller
{
    public function createPaymentIntent(Request $request) {
        // establecer la clave secreta de Stripe
        Stripe::setApiKey(config('services.stripe.key'));

        // monto recibido
        $amount = $request->input('amount');

        // crear el payment intent
        $intent = PaymentIntent::create([
            'amount' => $amount * 100, // stripe trabaja en centavos
            'currency' => 'cop',
            'metadata' => [
                'user_id' => auth()->id() // opcional para identificar el usuario
            ]
        ]);

        return response()->json([
            'clientSecret' => $intent->client_secret
        ]);
    }
}
