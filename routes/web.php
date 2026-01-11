<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

// =========================================================================================
// 1. IMPORTS
// =========================================================================================
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\Admin\CrudMedicineController; // Controller CRUD Obat
use App\Http\Controllers\Admin\DashboardController; // Controller Dashboard
use App\Http\Controllers\Admin\UserController; // Controller Dashboard
use App\Http\Controllers\Cashier\TransactionController;
use App\Http\Controllers\AuthController; // JANGAN LUPA IMPORT INI

// ---- AUTHENTICATION ROUTES ----
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ---- CUSTOMER REGISTRATION ----
Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
// ------------------------------

// =========================================================================================
// 2. PUBLIC / CUSTOMER ROUTES
// =========================================================================================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/medicine_detail/{slug}', [HomeController::class, 'show'])->name('show');
Route::get('/about', [HomeController::class, 'about'])->name('about');

// Midtrans Webhook (Excluded from CSRF)
use App\Http\Controllers\MidtransController;
Route::post('/midtrans/notification', [MidtransController::class, 'handleNotification'])->name('midtrans.notification');


// =========================================================================================
// 3. ADMIN ROUTES (Prefix: /admin)
// =========================================================================================
Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {

    // Rute Dasar Admin (admin.dashboard) -> Menampilkan Statistik
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('medicines/{id}/detail', [CrudMedicineController::class, 'detail']);

    Route::get('/users', [UserController::class, 'index'])->name('users.index'); // Halaman Daftar
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create'); // Halaman Form
    Route::post('/users', [UserController::class, 'store'])->name('users.store'); // Proses Form
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::resource('medicines', CrudMedicineController::class)->except(['show', 'edit']);

    // Manage Orders (Transactions)
    Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class)->only(['index', 'show']);

});


// =========================================================================================
// 4. CASHIER ROUTES
// =========================================================================================

use App\Http\Controllers\Cashier\DashboardController as CashierDashboardController;

// Bungkus semua route kasir Anda dalam group middleware ini
Route::middleware(['auth', 'is_cashier'])->prefix('cashier')->name('cashier.')->group(function () {


    Route::get('/', [CashierDashboardController::class, 'index'])->name('dashboard');

    // Route untuk Halaman Utama Transaksi Kasir
    Route::get('/transaction', [TransactionController::class, 'index'])->name('transaction.index');

    // Route untuk Tambah Item ke Keranjang
    Route::post('/transaction/cart/add', [TransactionController::class, 'cartAdd'])->name('transaction.cartAdd');

    // Route untuk Batalkan/Kosongkan Keranjang
    Route::post('/transaction/cart/clear', [TransactionController::class, 'cartClear'])->name('transaction.cartClear');

    // Route PENTING: Untuk Menyelesaikan Pembayaran dan Simpan ke DB
    Route::post('/transaction/complete', [TransactionController::class, 'completeTransaction'])->name('transaction.complete');

    Route::get('transaction/medicines/{id}/detail', [CrudMedicineController::class, 'detail'])->name('transaction.medicine.detail');

    Route::post('/transaction/process-payment', [TransactionController::class, 'processPayment'])->name('transaction.processPayment');

    // 1. Route untuk menampilkan halaman riwayat transaksi
    Route::get('/transaction/history', [TransactionController::class, 'history'])->name('transaction.history');

    // 2. Route untuk mengambil detail satu transaksi spesifik (dipanggil via AJAX)
    //    {transaction} adalah "Route Model Binding" yang otomatis mencari model Transaction berdasarkan ID
    Route::get('/transaction/{transaction}/details', [TransactionController::class, 'showDetails'])->name('transaction.showDetails');

    // 3. Route untuk menampilkan halaman faktur/invoice yang bisa dicetak
    Route::get('/transaction/{transaction}/invoice', [TransactionController::class, 'invoice'])->name('transaction.invoice');

    // ---- INCOMING ORDERS (PESANAN MASUK DARI CUSTOMER) ----
    Route::get('/orders/incoming', [App\Http\Controllers\Cashier\OrderController::class, 'incoming'])->name('orders.incoming');
    Route::get('/orders/counts', [App\Http\Controllers\Cashier\OrderController::class, 'getCounts'])->name('orders.counts');
    Route::post('/orders/{order}/confirm', [App\Http\Controllers\Cashier\OrderController::class, 'confirm'])->name('orders.confirm');
    Route::post('/orders/{order}/reject', [App\Http\Controllers\Cashier\OrderController::class, 'reject'])->name('orders.reject');
    Route::post('/orders/{order}/send', [App\Http\Controllers\Cashier\OrderController::class, 'sendOrder'])->name('orders.send');
    Route::post('/orders/{order}/arrived', [App\Http\Controllers\Cashier\OrderController::class, 'markArrived'])->name('orders.arrived');
    Route::post('/orders/{order}/update-tracking', [App\Http\Controllers\Cashier\OrderController::class, 'updateTrackingNumber'])->name('orders.updateTracking');
    Route::post('/orders/{order}/approve-cancel', [App\Http\Controllers\Cashier\OrderController::class, 'approveCancel'])->name('orders.approveCancel');
    Route::post('/orders/{order}/reject-cancel', [App\Http\Controllers\Cashier\OrderController::class, 'rejectCancel'])->name('orders.rejectCancel');
    Route::get('/orders/{order}/details', [App\Http\Controllers\Cashier\OrderController::class, 'show'])->name('orders.details');

});


// =========================================================================================
// 5. CUSTOMER AUTHENTICATED ROUTES
// =========================================================================================
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\CheckoutController;

Route::middleware(['auth', 'is_customer'])->prefix('customer')->name('customer.')->group(function () {

    // ---- CART ROUTES ----
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');

    // ---- CHECKOUT ROUTES ----
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    
    // ---- ORDER HISTORY ----
    Route::get('/orders', [CheckoutController::class, 'orders'])->name('orders.index');
    Route::get('/orders/{order}', [CheckoutController::class, 'orderDetail'])->name('orders.show');
    Route::get('/orders/{order}/track', [CheckoutController::class, 'track'])->name('orders.track');
    Route::post('/orders/{order}/cancel', [CheckoutController::class, 'cancelRequest'])->name('orders.cancel');
    Route::post('/orders/{order}/confirm', [CheckoutController::class, 'confirmOrder'])->name('orders.confirm');

    // ---- PROFILE SETTINGS ----
    Route::get('/profile', [\App\Http\Controllers\Customer\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [\App\Http\Controllers\Customer\ProfileController::class, 'update'])->name('profile.update');
});
