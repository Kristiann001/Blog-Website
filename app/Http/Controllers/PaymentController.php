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
            'phone_number' => 'required|numeric|digits:12', // Format: 2547...
        ]);

        $phoneNumber = $request->phone_number;
        $amount = $post->price;
        $callbackUrl = url('/api/payment/callback'); // Publicly accessible URL
        $reference = 'PL' . $post->id . 'U' . auth()->id();

        $response = $this->mpesaService->stkPush($phoneNumber, $amount, $callbackUrl, $reference);

        if ($response && $response->ResponseCode == "0") {
            Payment::create([
                'user_id' => auth()->id(),
                'post_id' => $post->id,
                'amount' => $amount,
                'status' => 'pending',
                'checkout_request_id' => $response->CheckoutRequestID,
                'phone_number' => $phoneNumber,
            ]);

            return back()->with('success', 'Payment initiated. Please check your phone for the STK push.');
        }

        return back()->with('error', 'Failed to initiate payment. Please try again.');
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
