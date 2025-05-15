<?php

namespace App\Http\Controllers\Api;

use Stripe\Stripe;
use Stripe\PaymentIntent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    public function createPaymentIntent(Request $request) {
        // establecer la clave secreta de Stripe
        Stripe::setApiKey(config('services.stripe.secret'));

        // monto recibido
        $amount = $request->input('amount');

        // crear el payment intent
        $intent = PaymentIntent::create([
            'amount' => $amount * 100, // stripe trabaja en centavos
            'currency' => 'usd',
            'metadata' => [
                'user_id' => auth()->id() // opcional para identificar el usuario
            ]
        ]);

        return response()->json([
            'clientSecret' => $intent->client_secret
        ]);
    }
}
