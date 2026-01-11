<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CustomerOrder;
use App\Models\CustomerOrderItem;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    /**
     * Display the checkout page.
     */
    public function index()
    {
        // Block cashier and admin from accessing checkout
        if (!Auth::user()->isCustomer()) {
            return redirect()->route('home')
                ->with('error', 'Checkout tidak tersedia untuk akun staff. Silakan gunakan akun customer.');
        }

        $cartItems = Cart::with('medicine')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('customer.cart.index')
                ->with('error', 'Keranjang belanja Anda kosong.');
        }

        $subtotal = $cartItems->sum(function ($item) {
            return $item->medicine->price * $item->quantity;
        });

        // Fixed Local Shipping Cost
        $fixedShippingCost = 15000; 

        $user = Auth::user();

        // Pass user with address data
        return view('customer.checkout.index', compact('cartItems', 'subtotal', 'user', 'fixedShippingCost'));
    }

    /**
     * Process the checkout and create order.
     */
    public function process(Request $request)
    {
        // Block cashier and admin from processing checkout
        if (!Auth::user()->isCustomer()) {
            return response()->json([
                'success' => false,
                'message' => 'Checkout tidak tersedia untuk akun staff.',
            ], 403);
        }

        $request->validate([
            'recipient_name' => 'required|string|max:255',
            'recipient_phone' => 'required|string|max:20',
            'street_address' => 'required|string',
            'province' => 'required|string',
            'city' => 'required|string',
            'district' => 'required|string',
            'village' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $cartItems = Cart::with('medicine')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Keranjang belanja kosong.',
            ], 400);
        }

        // Validate stock before processing
        foreach ($cartItems as $item) {
            if ($item->quantity > $item->medicine->stock) {
                return response()->json([
                    'success' => false,
                    'message' => "Stok {$item->medicine->name} tidak mencukupi.",
                ], 400);
            }
        }

        DB::beginTransaction();
        try {
            $subtotal = $cartItems->sum(function ($item) {
                return $item->medicine->price * $item->quantity;
            });

            // FIXED SHIPPING COST
            $shippingCost = 15000; 
            $totalAmount = $subtotal + $shippingCost;

            // Concatenate full address
            $fullAddress = "{$request->street_address}, Kel. {$request->village}, Kec. {$request->district}, {$request->city}, {$request->province}";

            // Create order
            $order = CustomerOrder::create([
                'order_number' => CustomerOrder::generateOrderNumber(),
                'user_id' => Auth::id(),
                'recipient_name' => $request->recipient_name,
                'recipient_phone' => $request->recipient_phone,
                'customer_email' => Auth::user()->email, // Email snapshot
                'shipping_address' => $fullAddress,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'province' => $request->province,
                'city' => $request->city,
                'postal_code' => '-', // Not mandatory yet
                'courier_code' => 'local',
                'courier_name' => 'Kurir Toko',
                'courier_service' => 'Reguler',
                'shipping_cost' => $shippingCost,
                'subtotal' => $subtotal,
                'total_amount' => $totalAmount,
                'payment_status' => 'pending',
                'status' => 'pending',
            ]);

            // Create order items and update stock
            foreach ($cartItems as $item) {
                CustomerOrderItem::create([
                    'customer_order_id' => $order->id,
                    'medicine_id' => $item->medicine_id,
                    'medicine_name' => $item->medicine->name,
                    'price' => $item->medicine->price,
                    'quantity' => $item->quantity,
                    'subtotal' => $item->medicine->price * $item->quantity,
                ]);

                // Reduce stock
                $medicine = Medicine::find($item->medicine_id);
                $medicine->stock -= $item->quantity;
                $medicine->total_sold += $item->quantity;
                $medicine->save();
            }

            // Clear cart
            Cart::where('user_id', Auth::id())->delete();

            // Get Midtrans Snap Token
            $snapToken = $this->getMidtransSnapToken($order);
            $order->update(['snap_token' => $snapToken]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dibuat!',
                'order' => $order,
                'redirect_url' => route('customer.orders.show', $order->id),
                'snap_token' => $snapToken,
            ]);

        } catch (\Throwable $e) {
            DB::rollBack();
            
            \Illuminate\Support\Facades\Log::error('Checkout Error: ' . $e->getMessage());
            \Illuminate\Support\Facades\Log::error($e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ], 500);
        }
    }

    /**
     * Display customer order history.
     */
    public function orders()
    {
        $orders = CustomerOrder::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('customer.orders.index', compact('orders'));
    }

    /**
     * Display order detail.
     */
    public function orderDetail(CustomerOrder $order)
    {
        // Ensure user can only see their own orders
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load('items.medicine');

        return view('customer.orders.show', compact('order'));
    }

    /**
     * Request order cancellation (Customer side).
     */
    public function cancelRequest(Request $request, CustomerOrder $order)
    {
        // Ensure user owns the order
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // Only allow request if status is pending or processing (not shipped)
        if (!in_array($order->status, ['pending', 'processing'])) {
             return redirect()->back()->with('error', 'Pesanan tidak dapat dibatalkan pada tahap ini.');
        }

        // Update status to cancel_requested
        $order->update([
            'status' => 'cancel_requested',
            'notes' => $request->input('reason', 'Permintaan pembatalan oleh pelanggan')
        ]);

        return redirect()->back()->with('success', 'Permintaan pembatalan telah dikirim. Menunggu konfirmasi kasir.');
    }

    /**
     * Confirm order receipt (Customer side).
     */
    public function confirmOrder(Request $request, CustomerOrder $order)
    {
        // Ensure user owns the order
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if ($order->status !== 'arrived') {
             return redirect()->back()->with('error', 'Pesanan belum dapat dikonfirmasi. Tunggu hingga paket tiba.');
        }

        DB::beginTransaction();
        try {
            $order->update([
                'status' => 'received',
                'transaction_type' => 'online via web',
                'updated_at' => now()
            ]);

            // Create transaction record now that customer has confirmed receipt
            $this->createTransactionFromOrder($order);

            DB::commit();

            return redirect()->back()->with('success', 'Terima kasih! Pesanan telah dikonfirmasi diterima.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Illuminate\Support\Facades\Log::error('Confirm Order Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengkonfirmasi pesanan.');
        }
    }

    /**
     * Create a Transaction and TransactionDetail from a CustomerOrder.
     */
    private function createTransactionFromOrder(CustomerOrder $order): void
    {
        // Ensure we have the latest data (including cashier_id updates)
        $order->refresh();

        // Generate invoice number from order_number
        $invoiceNumber = 'INV-' . str_replace('ORD-', '', $order->order_number);

        // Create main transaction
        $transaction = \App\Models\Transaction::create([
            'invoice_number' => $invoiceNumber,
            'total_amount' => $order->total_amount,
            'user_id' => $order->user_id,
            'user_name' => $order->recipient_name, // Use recipient_name from order for data integrity
            'user_email' => $order->customer_email, // Use snapshot from CustomerOrder
            'user_phone' => $order->recipient_phone, // Use recipient_phone from order
            'cashier_id' => $order->cashier_id,
            'cashier_name' => $order->cashier_name, // Use snapshot from CustomerOrder
            'cashier_email' => $order->cashier_email, // Use snapshot from CustomerOrder
            'cashier_phone' => $order->cashier_phone, // Use snapshot from CustomerOrder
            'transaction_date' => now(),
            'status' => 'completed',
            'transaction_type' => 'online',
        ]);

        // Create transaction details from order items
        foreach ($order->items as $item) {
            \App\Models\TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'medicine_id' => $item->medicine_id,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'subtotal' => $item->subtotal,
            ]);
        }

        \Illuminate\Support\Facades\Log::info("Transaction created from order: {$order->order_number}");
    }

     /**
     * Track Order (Stub for now, as local shipping usually has no tracking API)
     */
    public function track(CustomerOrder $order)
    {
        // For local shipping, we might just return the status or a static message
        return response()->json([
            'summary' => [
                'status' => 'ON_PROCESS',
                'waybill_date' => $order->created_at->format('Y-m-d')
            ],
            'manifest' => [
                [
                    'manifest_description' => 'Pesanan sedang diproses oleh toko.',
                    'manifest_date' => $order->created_at->format('Y-m-d'),
                    'manifest_time' => $order->created_at->format('H:i')
                ]
            ]
        ]);
    }


    /**
     * Generate Midtrans Snap Token
     */
    private function getMidtransSnapToken(CustomerOrder $order): string
    {
        // Configure Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => $order->order_number,
                'gross_amount' => (int) $order->total_amount,
            ],
            'customer_details' => [
                'first_name' => $order->recipient_name,
                'phone' => $order->recipient_phone,
                'email' => filter_var(Auth::user()->email, FILTER_VALIDATE_EMAIL) ? Auth::user()->email : 'noreply@epharma.com',
                'shipping_address' => [
                    'first_name' => $order->recipient_name,
                    'phone' => $order->recipient_phone,
                    'address' => $order->shipping_address,
                    'city' => $order->city,
                    'country_code' => 'IDN'
                ],
            ],
            'item_details' => $order->items->map(function ($item) {
                return [
                    'id' => $item->medicine_id,
                    'price' => (int) $item->price,
                    'quantity' => $item->quantity,
                    'name' => substr($item->medicine_name, 0, 50), // Midtrans limit
                ];
            })->push([
                'id' => 'SHIPPING',
                'price' => (int) $order->shipping_cost,
                'quantity' => 1,
                'name' => 'Biaya Pengiriman Lokal',
            ])->toArray(),
        ];

        return Snap::getSnapToken($params);
    }
}
