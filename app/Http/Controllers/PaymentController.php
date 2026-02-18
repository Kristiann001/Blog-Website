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
        $callbackUrl = env('MPESA_CALLBACK_URL', url('/api/payment/callback'));
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

            return back()
                ->with('success', 'Payment initiated! Please check your phone for the M-Pesa prompt and enter your PIN.')
                ->with('checkout_request_id', $response->CheckoutRequestID);
        }

        Log::error('M-Pesa STK Push failed', ['response' => $response]);

        return back()->with('error', 'Failed to initiate payment. Please check your phone number and try again.');
    }

    public function initiateApi(Request $request)
    {
        $request->validate([
            'phone_number' => [
                'required',
                'regex:/^254[0-9]{9}$/',
            ],
            'post_id' => 'required|exists:posts,id',
        ]);

        $post = Post::find($request->post_id);
        $phoneNumber = $request->phone_number;
        $amount = $post->price;
        $callbackUrl = env('MPESA_CALLBACK_URL', url('/api/payment/callback'));
        $reference = 'POST' . $post->id . 'API' . time();

        Log::info('Initiating API M-Pesa payment', [
            'post_id' => $post->id,
            'amount' => $amount,
            'phone' => $phoneNumber,
        ]);

        $response = $this->mpesaService->stkPush($phoneNumber, $amount, $callbackUrl, $reference);

        if ($response && isset($response->ResponseCode) && $response->ResponseCode == "0") {
            Payment::create([
                'user_id' => $request->user_id ?? auth()->id() ?? 1,
                'post_id' => $post->id,
                'amount' => $amount,
                'status' => 'pending',
                'checkout_request_id' => $response->CheckoutRequestID,
                'phone_number' => $phoneNumber,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Payment initiated successfully.',
                'checkout_request_id' => $response->CheckoutRequestID
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to initiate payment.',
            'response' => $response
        ], 500);
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

    public function status($checkoutRequestId)
    {
        $payment = Payment::where('checkout_request_id', $checkoutRequestId)->first();

        if (!$payment) {
            return response()->json(['status' => 'not_found'], 404);
        }

        // If pending, try to query Safaricom directly (especially useful for localhost)
        if ($payment->status === 'pending') {
            $response = $this->mpesaService->stkPushQuery($checkoutRequestId);
            
            if ($response && isset($response->ResultCode)) {
                if ($response->ResultCode == "0") {
                    $payment->update([
                        'status' => 'completed',
                        'mpesa_receipt_number' => $response->ResultDesc ?? 'Success',
                    ]);
                    Log::info('Payment Completed via Query: ' . $checkoutRequestId);
                } elseif (in_array($response->ResultCode, ['1032', '1037', '2001', '1'])) {
                    // 1032: Cancelled by user
                    // 1037: DS timeout
                    // 2001: Invalid initiator credentials
                    // 1: Internal error
                    $payment->update(['status' => 'failed']);
                    Log::info('Payment Failed via Query: ' . $checkoutRequestId . ' Code: ' . $response->ResultCode);
                } else {
                    // Other codes like 4999 are often transient or "not found yet"
                    Log::info('Payment still processing or transient code: ' . $checkoutRequestId . ' Code: ' . $response->ResultCode);
                }
            }
        }

        return response()->json([
            'status' => $payment->status,
            'receipt' => $payment->mpesa_receipt_number,
        ]);
    }
}
