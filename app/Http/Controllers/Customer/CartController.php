<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display the cart page.
     */
    public function index(Request $request)
    {
        $cartItems = Cart::with('medicine')
            ->where('user_id', Auth::id())
            ->get();

        $subtotal = $cartItems->sum(function ($item) {
            return $item->medicine->price * $item->quantity;
        });

        // Return JSON for AJAX requests (sidebar modal)
        if ($request->wantsJson()) {
            return response()->json([
                'cartItems' => $cartItems,
                'subtotal' => $subtotal,
            ]);
        }

        return view('customer.cart.index', compact('cartItems', 'subtotal'));
    }

    /**
     * Add item to cart (AJAX).
     */
    public function add(Request $request)
    {
        $request->validate([
            'medicine_id' => 'required|exists:medicines,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $medicine = Medicine::findOrFail($request->medicine_id);
        $quantity = (int) $request->quantity;

        // Check stock
        if ($quantity > $medicine->stock) {
            return response()->json([
                'success' => false,
                'message' => 'Kuantitas melebihi stok yang tersedia.',
            ], 400);
        }

        // Upsert cart item
        $cartItem = Cart::where('user_id', Auth::id())
            ->where('medicine_id', $medicine->id)
            ->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $quantity;
            if ($newQuantity > $medicine->stock) {
                return response()->json([
                    'success' => false,
                    'message' => 'Total kuantitas melebihi stok yang tersedia.',
                ], 400);
            }
            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'medicine_id' => $medicine->id,
                'quantity' => $quantity,
            ]);
        }

        $cartCount = Cart::where('user_id', Auth::id())->sum('quantity');

        return response()->json([
            'success' => true,
            'message' => $medicine->name . ' berhasil ditambahkan ke keranjang!',
            'cartCount' => $cartCount,
        ]);
    }

    /**
     * Update cart item quantity (AJAX).
     */
    public function update(Request $request)
    {
        $request->validate([
            'medicine_id' => 'sometimes|exists:medicines,id',
            'cart_id' => 'sometimes|exists:carts,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Support both cart_id and medicine_id for flexibility
        if ($request->has('medicine_id')) {
            $cartItem = Cart::where('user_id', Auth::id())
                ->where('medicine_id', $request->medicine_id)
                ->with('medicine')
                ->firstOrFail();
        } else {
            $cartItem = Cart::where('id', $request->cart_id)
                ->where('user_id', Auth::id())
                ->with('medicine')
                ->firstOrFail();
        }

        if ($request->quantity > $cartItem->medicine->stock) {
            return response()->json([
                'success' => false,
                'message' => 'Kuantitas melebihi stok yang tersedia.',
            ], 400);
        }

        $cartItem->update(['quantity' => $request->quantity]);

        // Recalculate totals
        $cartItems = Cart::with('medicine')
            ->where('user_id', Auth::id())
            ->get();

        $subtotal = $cartItems->sum(function ($item) {
            return $item->medicine->price * $item->quantity;
        });

        $cartCount = $cartItems->sum('quantity');

        return response()->json([
            'success' => true,
            'message' => 'Jumlah berhasil diperbarui.',
            'subtotal' => $subtotal,
            'cartCount' => $cartCount,
            'itemSubtotal' => $cartItem->medicine->price * $request->quantity,
        ]);
    }

    /**
     * Remove item from cart (AJAX).
     */
    public function remove(Request $request)
    {
        $request->validate([
            'medicine_id' => 'sometimes|exists:medicines,id',
            'cart_id' => 'sometimes|exists:carts,id',
        ]);

        // Support both cart_id and medicine_id
        if ($request->has('medicine_id')) {
            Cart::where('user_id', Auth::id())
                ->where('medicine_id', $request->medicine_id)
                ->delete();
        } else {
            Cart::where('id', $request->cart_id)
                ->where('user_id', Auth::id())
                ->delete();
        }

        // Recalculate totals
        $cartItems = Cart::with('medicine')
            ->where('user_id', Auth::id())
            ->get();

        $subtotal = $cartItems->sum(function ($item) {
            return $item->medicine->price * $item->quantity;
        });

        $cartCount = $cartItems->sum('quantity');

        return response()->json([
            'success' => true,
            'message' => 'Item berhasil dihapus dari keranjang.',
            'subtotal' => $subtotal,
            'cartCount' => $cartCount,
        ]);
    }

    /**
     * Clear entire cart.
     */
    public function clear()
    {
        Cart::where('user_id', Auth::id())->delete();

        return response()->json([
            'success' => true,
            'message' => 'Keranjang berhasil dikosongkan.',
            'cartCount' => 0,
        ]);
    }

    /**
     * Get cart count for navbar badge (AJAX).
     */
    public function count()
    {
        $count = Cart::where('user_id', Auth::id())->sum('quantity');

        return response()->json([
            'count' => $count,
        ]);
    }
}
