<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class SubscriptionController extends Controller
{
    public function checkout(Request $request, Service $service)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd', // or 'kes'
                    'unit_amount' => $service->price * 100, // Stripe uses cents
                    'product_data' => [
                        'name' => $service->title,
                        'description' => $service->description,
                    ],
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('services.subscription.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => url()->previous(),
            'customer_email' => Auth::user()->email,
        ]);

        // Save pending subscription
        ServiceSubscription::create([
            'user_id' => Auth::id(),
            'service_id' => $service->id,
            'stripe_payment_id' => $session->id,
            'status' => 'pending',
        ]);

        return redirect($session->url);
    }

    public function success(Request $request)
    {
        $sessionId = $request->query('session_id');

        $subscription = ServiceSubscription::where('stripe_payment_id', $sessionId)->firstOrFail();
        $subscription->update(['status' => 'completed']);

        return redirect()->route('services.index')->with('success', 'Subscription successful!');
    }
}
