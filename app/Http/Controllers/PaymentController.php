<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Post;
use App\Services\MpesaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    private $mpesaService;

    public function __construct(MpesaService $mpesaService)
    {
        $this->mpesaService = $mpesaService;
    }

    public function initiate(Request $request, Post $post)
    {
        if (auth()->user()->role === 'admin') {
            return back()->with('error', 'Administrators cannot purchase content.');
        }

        $request->validate([
            'phone_number' => [
                'required',
                'regex:/^254[0-9]{9}$/',
            ],
        ], [
            'phone_number.required' => 'Please enter your M-Pesa phone number.',
            'phone_number.regex' => 'Phone number must be in format 254XXXXXXXXX (12 digits).',
        ]);

        // Check if user already purchased
        if (auth()->user()->hasPurchased($post)) {
            return back()->with('success', 'You already have access to this content!');
        }

        $phoneNumber = $request->phone_number;
        $amount = $post->price;
        $callbackUrl = url('/api/payment/callback');
        $reference = 'POST' . $post->id . 'USER' . auth()->id() . time();

        Log::info('Initiating M-Pesa payment', [
            'user_id' => auth()->id(),
            'post_id' => $post->id,
            'amount' => $amount,
            'phone' => $phoneNumber,
        ]);

        $response = $this->mpesaService->stkPush($phoneNumber, $amount, $callbackUrl, $reference);

        if ($response && isset($response->ResponseCode) && $response->ResponseCode == "0") {
            Payment::create([
                'user_id' => auth()->id(),
                'post_id' => $post->id,
                'amount' => $amount,
                'status' => 'pending',
                'checkout_request_id' => $response->CheckoutRequestID,
                'phone_number' => $phoneNumber,
            ]);

            Log::info('M-Pesa STK Push successful', ['checkout_id' => $response->CheckoutRequestID]);

            return back()->with('success', 'Payment initiated! Please check your phone for the M-Pesa prompt and enter your PIN.');
        }

        Log::error('M-Pesa STK Push failed', ['response' => $response]);

        return back()->with('error', 'Failed to initiate payment. Please check your phone number and try again.');
    }

    public function callback(Request $request)
    {
        $data = json_decode($request->getContent());
        
        if (!$data) {
            Log::error('M-Pesa Callback Error: Empty data');
            return response()->json(['ResultCode' => 1, 'ResultDesc' => 'Empty data']);
        }

        $resultCode = $data->Body->stkCallback->ResultCode;
        $checkoutRequestID = $data->Body->stkCallback->CheckoutRequestID;

        $payment = Payment::where('checkout_request_id', $checkoutRequestID)->first();

        if ($payment) {
            if ($resultCode == 0) {
                $payment->update([
                    'status' => 'completed',
                    'mpesa_receipt_number' => $data->Body->stkCallback->CallbackMetadata->Item[1]->Value,
                ]);
                Log::info('Payment Completed: ' . $checkoutRequestID);
            } else {
                $payment->update(['status' => 'failed']);
                Log::info('Payment Failed: ' . $checkoutRequestID);
            }
        }

        return response()->json(['ResultCode' => 0, 'ResultDesc' => 'Success']);
    }
}
