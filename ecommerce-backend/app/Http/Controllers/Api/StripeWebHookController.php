<?php

namespace App\Http\Controllers\Api;

use Stripe\Webhook;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;

class StripeWebHookController extends Controller
{
    public function handle(Request $request) {
        // validar la firma
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = env('STRIPE_WEBHOOK_SECRET'); // secret definido en el .env

        try {
            $event = Webhook::constructEvent(
                $payload, $sigHeader, $endpointSecret
            );
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
            return response('Invalid signature', 400);
        }

        // si el payment intent es exitoso
        if ($event->type === 'payment_intent.succeeded') {
            $paymentIntent = $event->data->object; // se accede a data -> object del evento

            // se obtiene el id de la orden enviado como metadata
            $orderId = $paymentIntent->metadata->order_id ?? null;

            // si el id de la orden es accedido correctamente
            if ($orderId) {
                $order = Order::find($orderId); // se consulta la orden en la base de datos
                if ($order) {
                    // si la orden existe, se actualiza su estado
                    $order->estado = 'pagado';
                    $order->save();
                }
            }

            return response()->json(['status' => 'success']);
        }
    }
}
