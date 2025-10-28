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
        try {
            // Get raw POST data
            $rawPayload = file_get_contents('php://input');
            $payload = json_decode($rawPayload, true);


            // Create notification instance with raw input
            $notification = new Notification();

            $transaction = $notification->transaction_status;
            $type = $notification->payment_type;
            $orderId = $notification->order_id;
            $fraud = $notification->fraud_status;

          

            // Find rental by transaction_id
            $rental = Rental::where('transaction_id', $orderId)->first();

            if (!$rental) {
                Log::error('Rental not found for transaction: ' . $orderId);
                return response()->json(['status' => 'error', 'message' => 'Rental not found']);
            }

          

            // Update payment status based on transaction status
            $updateData = [];

            switch ($transaction) {
                case 'capture':
                    if ($type == 'credit_card') {
                        if ($fraud == 'challenge') {
                            $updateData['payment_status'] = 'challenge';
                        } else {
                            $updateData['payment_status'] = 'paid';
                            $updateData['status'] = 'active';
                        }
                    }
                    break;

                case 'settlement':
                    $updateData['payment_status'] = 'paid';
                    $updateData['status'] = 'active';
                    break;

                case 'pending':
                    $updateData['payment_status'] = 'pending';
                    break;

                case 'deny':
                case 'cancel':
                    $updateData['payment_status'] = 'failed';
                    $updateData['status'] = 'cancelled';
                    break;

                case 'expire':
                    $updateData['payment_status'] = 'expired';
                    $updateData['status'] = 'cancelled';
                    break;

                default:
                    Log::warning('Unhandled transaction status:', ['status' => $transaction]);
                    break;
            }

            // Update rental status
            $rental->update($updateData);

            // Update unit status based on rental status
            if ($rental->unit) {
                $unitStatus = 'available';
                if ($rental->status === 'active') {
                    $unitStatus = 'occupied';
                }

                $rental->unit->update(['status' => $unitStatus]);

            }



            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            Log::error('Payment callback error: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    // Handle payment success redirect
    public function success(Request $request)
    {
        $orderId = $request->get('order_id');
        $rental = Rental::where('transaction_id', $orderId)->first();

        if ($rental) {
            return redirect()->route('rentals.show', $rental->id)
                ->with('success', 'Pembayaran berhasil! Status pembayaran akan diperbarui dalam beberapa saat.');
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
