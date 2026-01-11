<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Transaction::with(['user', 'cashier'])->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $transaction = Transaction::with(['user', 'cashier', 'details.medicine'])->find($id);

        if (!$transaction) {
            return response()->json(['error' => 'Transaction not found'], 404);
        }

        // For online orders, load customer order with shipping info
        if ($transaction->transaction_type === 'online') {
            // Convert INV-20260111-ABC to ORD-20260111-ABC
            $orderNumber = str_replace('INV-', 'ORD-', $transaction->invoice_number);
            $customerOrder = \App\Models\CustomerOrder::where('order_number', $orderNumber)->first();
            $transaction->customer_order = $customerOrder;
        }

        return response()->json($transaction);
    }
}
