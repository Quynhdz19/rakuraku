<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\PaymentIntent;

class StripePaymentController extends Controller
{
    public function createPaymentIntent(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'amount' => 'required|numeric|min:1'
        ]);

        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $customer = Customer::create([
                'name' => $request->name,
                'email' => $request->email
            ]);

            $paymentIntent = PaymentIntent::create([
                'amount' => intval($request->amount),
                'currency' => 'jpy',
                'customer' => $customer->id,
                'payment_method_types' => ['card'],
                'payment_method' => 'pm_card_visa',
                'confirm' => true,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'PaymentIntent created successfully',
                'client_secret' => $paymentIntent->client_secret,
                'amount_jpy' => $paymentIntent->amount,
                'customer' => [
                    'id' => $customer->id,
                    'name' => $customer->name,
                    'email' => $customer->email,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Stripe error: ' . $e->getMessage()
            ], 500);
        }
    }
}
