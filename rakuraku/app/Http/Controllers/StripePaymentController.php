<?php

namespace app\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
class StripePaymentController extends Controller
{
    public function createPaymentIntent(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => $request->amount, // $request->amount = 1000 sẽ là $10.00 USD.
                'currency' => 'usd',
                'description' => 'Payment via Laravel Stripe API',
                'payment_method_types' => ['card'],
            ]);

            return response()->json([
                'message' => 'PaymentIntent created successfully',
                'clientSecret' => $paymentIntent->client_secret,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

}
