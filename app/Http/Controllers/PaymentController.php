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
        
        // Use local callback URL for demo purposes
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
            $payment = Payment::create([
                'user_id' => auth()->id(),
                'post_id' => $post->id,
                'amount' => $amount,
                'status' => 'pending',
                'checkout_request_id' => $response->CheckoutRequestID,
                'phone_number' => $phoneNumber,
            ]);

            Log::info('M-Pesa STK Push successful', ['checkout_id' => $response->CheckoutRequestID]);

            // For demo purposes: simulate successful payment after 3 seconds
            if (config('services.mpesa.env') == 'sandbox' && str_starts_with($response->CheckoutRequestID, 'DEMO_')) {
                // Schedule a simulated callback
                $this->simulateCallback($payment);
            }

            return back()
                ->with('success', 'Payment initiated! Please check your phone for the M-Pesa prompt and enter your PIN.')
                ->with('checkout_request_id', $response->CheckoutRequestID);
        }

        Log::error('M-Pesa STK Push failed', ['response' => $response]);

        return back()->with('error', 'Failed to initiate payment. Please check your phone number and try again.');
    }

    private function simulateCallback($payment)
    {
        // Simulate callback after 3 seconds for demo
        dispatch(function () use ($payment) {
            sleep(3);
            $payment->update([
                'status' => 'completed',
                'mpesa_receipt_number' => 'DEMO_RECEIPT_' . time(),
            ]);
            Log::info('Demo payment completed automatically', ['payment_id' => $payment->id]);
        })->afterResponse();
    }

    public function initiateApi(Request $request)
    {
        // Require authentication
        if (!auth()->check()) {
            return response()->json(['success' => false, 'message' => 'Please log in to make a purchase.'], 401);
        }

        $request->validate([
            'phone_number' => [
                'required',
                'regex:/^254[0-9]{9}$/',
            ],
            'post_id' => 'required|exists:posts,id',
        ]);

        $post = Post::find($request->post_id);
        $user = auth()->user();

        // Check if already purchased
        if ($user->hasPurchased($post)) {
            return response()->json(['success' => false, 'message' => 'You already have access to this content!']);
        }

        $phoneNumber = $request->phone_number;
        $amount = $post->price;
        
        // Use local callback URL for demo purposes
        $callbackUrl = url('/api/payment/callback');
        $reference = 'POST' . $post->id . 'USER' . $user->id . time();

        Log::info('Initiating API M-Pesa payment', [
            'user_id' => $user->id,
            'post_id' => $post->id,
            'amount' => $amount,
            'phone' => $phoneNumber,
            'callback_url' => $callbackUrl,
        ]);

        $response = $this->mpesaService->stkPush($phoneNumber, $amount, $callbackUrl, $reference);

        if ($response && isset($response->ResponseCode) && $response->ResponseCode == "0") {
            $payment = Payment::create([
                'user_id' => $user->id,
                'post_id' => $post->id,
                'amount' => $amount,
                'status' => 'pending',
                'checkout_request_id' => $response->CheckoutRequestID,
                'phone_number' => $phoneNumber,
            ]);

            // For demo purposes: simulate successful payment after 3 seconds
            if (config('services.mpesa.env') == 'sandbox' && str_starts_with($response->CheckoutRequestID, 'DEMO_')) {
                $this->simulateCallback($payment);
            }

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

        // If already resolved, return immediately — no need to query Safaricom
        if (in_array($payment->status, ['completed', 'failed'])) {
            return response()->json([
                'status'  => $payment->status,
                'receipt' => $payment->mpesa_receipt_number,
            ]);
        }

        // For pending payments: try the Safaricom query API only if the payment
        // was created within the last 5 minutes (avoids hammering the API forever)
        // and only if we haven't already tried recently (tracked via updated_at).
        $ageSeconds = now()->diffInSeconds($payment->created_at);
        $lastCheckSeconds = now()->diffInSeconds($payment->updated_at);

        // Only query Safaricom if: payment < 5 min old AND last check was > 20s ago
        if ($ageSeconds < 300 && $lastCheckSeconds >= 20) {
            $response = $this->mpesaService->stkPushQuery($checkoutRequestId);

            if ($response && isset($response->ResultCode)) {
                if ($response->ResultCode == "0") {
                    $payment->update([
                        'status'               => 'completed',
                        'mpesa_receipt_number' => $response->ResultDesc ?? 'Success',
                    ]);
                    Log::info('Payment Completed via Query: ' . $checkoutRequestId);
                } elseif (in_array((string)$response->ResultCode, ['1032', '1037', '2001', '1', '1031', '9999'])) {
                    $payment->update(['status' => 'failed']);
                    Log::info('Payment Failed via Query: ' . $checkoutRequestId . ' Code: ' . $response->ResultCode);
                } else {
                    // Transient / still processing — touch updated_at to throttle next check
                    $payment->touch();
                    Log::info('Payment still processing: ' . $checkoutRequestId . ' Code: ' . $response->ResultCode);
                }
            } else {
                // API unavailable (e.g. 403) — touch to throttle, don't crash
                $payment->touch();
            }

            $payment->refresh();
        }

        return response()->json([
            'status'  => $payment->status,
            'receipt' => $payment->mpesa_receipt_number,
        ]);
    }
}
