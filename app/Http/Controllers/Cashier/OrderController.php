<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\CustomerOrder;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display all orders with tab navigation.
     */
    public function incoming()
    {
        $incomingOrders = CustomerOrder::with('user', 'items')
            ->whereIn('status', ['pending', 'processing', 'cancel_requested'])
            ->orderByRaw("FIELD(status, 'cancel_requested', 'pending', 'processing')")
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'incoming_page');

        $shippedOrders = CustomerOrder::with('user', 'items')
            ->whereIn('status', ['shipped', 'arrived'])
            ->orderByRaw("FIELD(status, 'shipped', 'arrived')")
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'shipped_page');

        $completedOrders = CustomerOrder::with('user', 'items')
            ->where('status', 'received')
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'completed_page');

        $cancelledOrders = CustomerOrder::with('user', 'items')
            ->where('status', 'cancelled')
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'cancelled_page');

        $paidPendingCount = CustomerOrder::where('status', 'pending')
            ->where('payment_status', 'paid')
            ->count();

        return view('cashier.orders.incoming', compact('incomingOrders', 'shippedOrders', 'completedOrders', 'cancelledOrders', 'paidPendingCount'));
    }

    /**
     * Confirm the order (process it).
     * Only allow if payment is paid.
     */
    public function confirm(CustomerOrder $order)
    {
        // Check if payment is paid
        if ($order->payment_status !== 'paid') {
            return redirect()->back()->with('error', 'Pesanan tidak dapat diproses. Pembayaran belum lunas.');
        }

        $order->update([
            'status' => 'processing',
            'cashier_id' => auth()->id(),
            'cashier_name' => auth()->user()->name,
            'cashier_email' => auth()->user()->email,
            'cashier_phone' => auth()->user()->phone_number,
        ]);

        return redirect()->back()->with('success', 'Pesanan #' . $order->order_number . ' berhasil dikonfirmasi.');
    }

    /**
     * Reject the order (even if paid).
     * Restores stock and marks as cancelled.
     */
    public function reject(CustomerOrder $order)
    {
        // Only allow rejection for pending orders (or maybe processing if needed, but request said "manual and confirmed")
        if ($order->status !== 'pending') {
            return redirect()->back()->with('error', 'Status pesanan tidak valid untuk aksi ini.');
        }

        // Restore stock
        foreach ($order->items as $item) {
            $med = \App\Models\Medicine::find($item->medicine_id);
            if ($med) {
                $med->stock += $item->quantity;
                $med->total_sold -= $item->quantity;
                $med->save();
            }
        }

        $updateData = [
            'status' => 'cancelled',
            'cashier_id' => auth()->id(),
            'notes' => 'Ditolak oleh kasir (Stok habis/kendala lain)',
        ];

        // If order was paid, change payment status to refunded
        if ($order->payment_status == 'paid') {
            $updateData['payment_status'] = 'refunded';
            $updateData['notes'] .= ' (Dana akan dikembalikan).';
        }

        $order->update($updateData);

        return redirect()->back()->with('success', 'Pesanan #' . $order->order_number . ' berhasil ditolak. Stok telah dikembalikan.');
    }

    /**
     * Approve cancellation request (Cashier side).
     */
    public function approveCancel(CustomerOrder $order)
    {
        if ($order->status !== 'cancel_requested') {
            return redirect()->back()->with('error', 'Status pesanan tidak valid untuk aksi ini.');
        }

        // Only restore stock if the order was already shipped (stock was deducted)
        if (in_array($order->status, ['shipped', 'arriving'])) {
            foreach ($order->items as $item) {
                $med = \App\Models\Medicine::find($item->medicine_id);
                if ($med) {
                    $med->stock += $item->quantity;
                    $med->total_sold -= $item->quantity;
                    $med->save();
                }
            }
        }

        $updateData = [
            'status' => 'cancelled',
            'cashier_id' => auth()->id(),
        ];

        // If order was paid, change payment status to refunded
        if ($order->payment_status == 'paid') {
            $updateData['payment_status'] = 'refunded';
            $updateData['notes'] = $order->notes . ' (Dana akan dikembalikan).';
        }

        $order->update($updateData);

        return redirect()->back()->with('success', 'Permintaan pembatalan pesanan #' . $order->order_number . ' disetujui.');
    }

    /**
     * Reject cancellation request (Cashier side).
     */
    public function rejectCancel(CustomerOrder $order)
    {
        if ($order->status !== 'cancel_requested') {
            return redirect()->back()->with('error', 'Status pesanan tidak valid untuk aksi ini.');
        }

        // Return to processing
        $order->update([
            'status' => 'processing',
            'cashier_id' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Permintaan pembatalan pesanan #' . $order->order_number . ' ditolak. Pesanan dilanjutkan.');
    }

    /**
     * Mark order as shipped (Kirim Pesanan).
     */
    public function sendOrder(Request $request, CustomerOrder $order)
    {
        $order->update([
            'status' => 'shipped',
            'cashier_id' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Pesanan #' . $order->order_number . ' berhasil dikirim.');
    }

    /**
     * Mark order as arrived (change from shipped to arrived).
     */
    public function markArrived(CustomerOrder $order)
    {
        if ($order->status !== 'shipped') {
            return redirect()->back()->with('error', 'Status pesanan tidak valid untuk aksi ini.');
        }

        $order->update([
            'status' => 'arrived',
            'cashier_id' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Pesanan #' . $order->order_number . ' - Paket telah tiba.');
    }

    
    /**
     * Show order details (optional, if using AJAX modal)
     */
    public function show(CustomerOrder $order)
    {
        $order->load('items.medicine', 'user');
        return view('cashier.orders.show', compact('order'));
    }

    /**
     * Get order counts for real-time polling.
     */
    public function getCounts()
    {
        $incomingCount = CustomerOrder::whereIn('status', ['pending', 'processing', 'cancel_requested'])->count();
        $shippedCount = CustomerOrder::whereIn('status', ['shipped', 'arrived'])->count();
        $completedCount = CustomerOrder::where('status', 'received')->count();
        $cancelledCount = CustomerOrder::where('status', 'cancelled')->count();
        
        // Count orders that are paid but still pending (awaiting cashier confirmation)
        $paidPendingCount = CustomerOrder::where('status', 'pending')
            ->where('payment_status', 'paid')
            ->count();
        
        // Get the latest order timestamp for change detection
        $latestOrder = CustomerOrder::whereIn('status', ['pending', 'processing', 'cancel_requested'])
            ->latest()
            ->first();
        
        // Get latest paid order for payment detection
        $latestPaidOrder = CustomerOrder::where('payment_status', 'paid')
            ->latest('paid_at')
            ->first();

        return response()->json([
            'incoming' => $incomingCount,
            'shipped' => $shippedCount,
            'completed' => $completedCount,
            'cancelled' => $cancelledCount,
            'cancel_requested' => CustomerOrder::where('status', 'cancel_requested')->count(),
            'paid_pending' => $paidPendingCount,
            'latest_id' => $latestOrder?->id,
            'latest_at' => $latestOrder?->created_at?->toISOString(),
            'latest_paid_at' => $latestPaidOrder?->paid_at?->toISOString(),
        ]);
    }
}
