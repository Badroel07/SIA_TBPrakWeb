<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CustomerOrder extends Model
{
    protected $fillable = [
        'order_number',
        'user_id',
        'cashier_id',
        'cashier_name',
        'cashier_email',
        'cashier_phone',
        'recipient_name',
        'recipient_phone',
        'customer_email',
        'shipping_address',
        'latitude',
        'longitude',
        'province',
        'city',
        'postal_code',
        'courier_code',
        'courier_name',
        'courier_service',
        'tracking_number',
        'shipping_cost',
        'subtotal',
        'total_amount',
        'payment_status',
        'snap_token',
        'midtrans_transaction_id',
        'payment_type',
        'paid_at',
        'status',
        'notes',
        'transaction_type',
    ];

    protected $casts = [
        'shipping_cost' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    /**
     * Generate unique order number.
     */
    public static function generateOrderNumber(): string
    {
        $prefix = 'ORD';
        $date = now()->format('Ymd');
        $random = strtoupper(substr(uniqid(), -5));
        return "{$prefix}-{$date}-{$random}";
    }

    /**
     * Get the user that placed this order.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the cashier that processed this order.
     */
    public function cashier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cashier_id');
    }

    /**
     * Get the order items.
     */
    public function items(): HasMany
    {
        return $this->hasMany(CustomerOrderItem::class);
    }
}
