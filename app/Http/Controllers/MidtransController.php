<?php

namespace App\Http\Controllers;

use App\Models\CustomerOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MidtransController extends Controller
{
    public function __construct()
    {
        // Set configuration
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;
    }

    public function handleNotification(Request $request)
    {
        Log::info('Midtrans Notification Recieved:', $request->all());

        try {
            // Check signature if verify is needed, but Notification class handles parsing
            // For Laravel, request->all() might be pre-parsed JSON, but Midtrans PHP lib reads php://input
            // We can try to use the library's built-in handler
            
            $notification = new \Midtrans\Notification();
            
            $transactionStatus = $notification->transaction_status;
            $type = $notification->payment_type;
            $orderId = $notification->order_id;
            $fraud = $notification->fraud_status;

            Log::info("Order ID: $orderId, Status: $transactionStatus");

            // Find order
            // Note: Midtrans usually sends order_id exactly as sent.
            // Our generateOrderNumber() creates strings like 'ORD-...'
            $order = CustomerOrder::where('order_number', $orderId)->first();

            if (!$order) {
                Log::error("Order not found: $orderId");
                return response()->json(['message' => 'Order not found'], 404);
            }

            if ($transactionStatus == 'capture') {
                // For credit card
                if ($type == 'credit_card') {
                    if ($fraud == 'challenge') {
                        $order->update(['payment_status' => 'pending']);
                    } else {
                        $order->update([
                            'payment_status' => 'paid',
                            'paid_at' => now(),
                            // 'status' => 'processing' // Removed to allow manual cashier confirmation
                        ]);
                    }
                }
            } else if ($transactionStatus == 'settlement') {
                $order->update([
                    'payment_status' => 'paid',
                    'paid_at' => now(),
                    // 'status' => 'processing' // Removed to allow manual cashier confirmation
                ]);
            } else if ($transactionStatus == 'pending') {
                $order->update(['payment_status' => 'pending']);
            } else if ($transactionStatus == 'deny') {
                $order->update(['payment_status' => 'failed']);
            } else if ($transactionStatus == 'expire') {
                $order->update(['payment_status' => 'expired']);
            } else if ($transactionStatus == 'cancel') {
                $order->update(['payment_status' => 'cancelled']);
            }

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            Log::error('Midtrans Notification Error: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}

