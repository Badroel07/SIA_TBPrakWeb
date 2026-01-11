<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'invoice_number',
        'total_amount',
        'cash_received',
        'user_id',
        'user_name',
        'user_email',
        'user_phone',
        'cashier_id',
        'cashier_name',
        'cashier_email',
        'cashier_phone',
        'transaction_date',
        'status',
        'transaction_type',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'transaction_date' => 'datetime',
        'total_amount' => 'decimal:2',
    ];

    /**
     * Get the user that owns the transaction.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the cashier that processed the transaction.
     */
    public function cashier()
    {
        return $this->belongsTo(User::class, 'cashier_id');
    }

    /**
     * Get the details for the transaction.
     */
    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }
}
