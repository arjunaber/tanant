<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Notification;

class PaymentController extends Controller
{
    public function __construct()
    {
        // Set Midtrans configuration
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = config('services.midtrans.is_sanitized');
        Config::$is3ds = config('services.midtrans.is_3ds');
    }

    // Handle Midtrans callback
    public function callback(Request $request)
    {
        Log::info('Midtrans Callback Received:', $request->all());

        $orderId = $request->input('order_id');
        $transactionStatus = $request->input('transaction_status');
        $paymentType = $request->input('payment_type');

        $rental = Rental::where('transaction_id', $orderId)->first();

        if (!$rental) {
            Log::warning("Rental not found for order_id: $orderId");
            return response()->json(['status' => 'error', 'message' => 'Rental not found'], 404);
        }

        Log::info("Before update rental:", [
            'order_id' => $orderId,
            'current_status' => $rental->status,
            'current_payment' => $rental->payment_status
        ]);

        switch ($transactionStatus) {
            case 'capture':
            case 'settlement':
                $rental->update([
                    'payment_status' => 'paid',
                    'status' => 'active',
                ]);
                break;

            case 'pending':
                $rental->update(['payment_status' => 'pending']);
                break;

            case 'deny':
            case 'cancel':
            case 'expire':
                $rental->update([
                    'payment_status' => 'failed',
                    'status' => 'cancelled',
                ]);
                break;
        }

        $rental->refresh();

        Log::info("After update rental:", [
            'rental_id' => $rental->id,
            'payment_status' => $rental->payment_status,
            'status' => $rental->status
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Callback processed successfully',
            'data' => [
                'order_id' => $orderId,
                'transaction_status' => $transactionStatus,
                'payment_status' => $rental->payment_status,
            ],
        ]);
    }



    // Handle payment success redirect
    public function success(Request $request)
    {
        $orderId = $request->get('order_id');
        $rental = Rental::where('transaction_id', $orderId)->first();

        if ($rental) {
            // Jika masih pending, update jadi paid
            if ($rental->payment_status === 'pending') {
                $rental->update([
                    'payment_status' => 'paid',
                    'status' => 'active',
                ]);
            }

            return redirect()->route('rentals.show', $rental->id)
                ->with('success', 'Pembayaran berhasil! Status pembayaran telah diperbarui.');
        }

        return redirect()->route('rentals.my-rentals')
            ->with('error', 'Pembayaran berhasil, namun data peminjaman tidak ditemukan.');
    }


    // Handle payment failure redirect
    public function failed(Request $request)
    {
        $orderId = $request->get('order_id');
        $rental = Rental::where('transaction_id', $orderId)->first();

        if ($rental) {
            $rental->update(['payment_status' => 'failed']);
            return redirect()->route('rentals.show', $rental->id)
                ->with('error', 'Pembayaran gagal. Silakan coba lagi.');
        }

        return redirect()->route('rentals.my-rentals')
            ->with('error', 'Pembayaran gagal.');
    }

    // Handle payment pending redirect
    public function pending(Request $request)
    {
        $orderId = $request->get('order_id');
        $rental = Rental::where('transaction_id', $orderId)->first();

        if ($rental) {
            return redirect()->route('rentals.show', $rental->id)
                ->with('info', 'Pembayaran sedang diproses. Status akan diperbarui dalam beberapa saat.');
        }

        return redirect()->route('rentals.my-rentals')
            ->with('info', 'Pembayaran sedang diproses.');
    }

    // Check payment status
    public function checkStatus($rentalId)
    {
        $rental = Rental::findOrFail($rentalId);

        if ($rental->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json([
            'payment_status' => $rental->payment_status,
            'transaction_id' => $rental->transaction_id,
            'payment_url' => $rental->payment_url,
        ]);
    }
}
