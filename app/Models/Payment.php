<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'payment_method',
        'transaction_id',
        'amount',
        'status',
        'gateway_response'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'gateway_response' => 'array'
    ];

    // ============ RELATIONSHIPS ============

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // ============ ACCESSORS ============

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'warning',
            'completed' => 'success',
            'failed' => 'danger',
            'refunded' => 'secondary'
        ];
        return $badges[$this->status] ?? 'secondary';
    }

    public function getStatusLabelAttribute()
    {
        $labels = [
            'pending' => 'Pending',
            'completed' => 'Completed',
            'failed' => 'Failed',
            'refunded' => 'Refunded'
        ];
        return $labels[$this->status] ?? ucfirst($this->status);
    }

    public function getFormattedAmountAttribute()
    {
        return 'Rs. ' . number_format($this->amount, 2);
    }

    public function getPaymentMethodLabelAttribute()
    {
        $methods = [
            'cash' => 'Cash',
            'card' => 'Card',
            'bank_transfer' => 'Bank Transfer',
            'mobile_banking' => 'Mobile Banking',
            'Cash on Delivery' => 'Cash on Delivery',
            'esewa' => 'eSewa',
            'khalti' => 'Khalti'
        ];
        return $methods[$this->payment_method] ?? ucfirst($this->payment_method);
    }
}
