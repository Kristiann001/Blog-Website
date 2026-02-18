<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * List all payments (admin view).
     */
    public function index()
    {
        $payments = Payment::with('user', 'post')
            ->latest()
            ->paginate(20);

        return view('admin.payments.index', compact('payments'));
    }

    /**
     * Manually approve a pending payment (admin only).
     */
    public function approve(Payment $payment)
    {
        if ($payment->status === 'completed') {
            return back()->with('info', 'Payment is already completed.');
        }

        $payment->update([
            'status'               => 'completed',
            'mpesa_receipt_number' => 'MANUAL-APPROVAL-' . strtoupper(uniqid()),
        ]);

        Log::info('Payment manually approved by admin', [
            'payment_id' => $payment->id,
            'user_id'    => $payment->user_id,
            'post_id'    => $payment->post_id,
            'admin_id'   => auth()->id(),
        ]);

        return back()->with('success', 'Payment approved. User can now access the content.');
    }

    /**
     * Reject / mark a payment as failed (admin only).
     */
    public function reject(Payment $payment)
    {
        $payment->update(['status' => 'failed']);

        Log::info('Payment rejected by admin', [
            'payment_id' => $payment->id,
            'admin_id'   => auth()->id(),
        ]);

        return back()->with('success', 'Payment marked as failed.');
    }
}
