<?php

namespace App\Models;

use App\Models\Address;
use App\Models\Payment;
use App\Models\RewardTransaction;
use App\Models\User;
use App\Models\Coupon;
use App\Models\OrderItem;


use Illuminate\Database\Eloquent\Model;

class Order extends Model

{
    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_SHIPPED = 'shipped';
    const STATUS_DELIVERED = 'delivered';
    const STATUS_CANCELLED = 'cancelled';
    protected $fillable = [
        'user_id',
        'address_id',
        'coupon_id',
        'order_number',
        'subtotal',
        'discount',
        'delivery_charge',
        'tax',
        'grand_total',
        'payment_method',
        'payment_status',
        'order_status',
        'transaction_id',
        'notes',
        'shipped_at',
        'delivered_at'
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'delivery_charge' => 'decimal:2',
        'tax' => 'decimal:2',
        'grand_total' => 'decimal:2',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class)->withDefault();
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }


    public function rewardTransaction()
    {
        return $this->hasOne(RewardTransaction::class);
    }

    public function getStatusLabelAttribute()
    {
        return [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_PROCESSING => 'Processing',
            self::STATUS_SHIPPED => 'Shipped',
            self::STATUS_DELIVERED => 'Delivered',
            self::STATUS_CANCELLED => 'Cancelled',
        ][$this->order_status] ?? 'Unknown';
    }


    public function getStatusColorAttribute()
    {
        return [
            self::STATUS_PENDING => 'warning',
            self::STATUS_PROCESSING => 'info',
            self::STATUS_SHIPPED => 'primary',
            self::STATUS_DELIVERED => 'success',
            self::STATUS_CANCELLED => 'danger',
        ][$this->order_status] ?? 'secondary';
    }

    
    public function isPending()
    {
        return $this->order_status === self::STATUS_PENDING;
    }

    public function isProcessing()
    {
        return $this->order_status === self::STATUS_PROCESSING;
    }

    public function isShipped()
    {
        return $this->order_status === self::STATUS_SHIPPED;
    }

    public function isDelivered()
    {
        return $this->order_status === self::STATUS_DELIVERED;
    }

    public function isCancelled()
    {
        return $this->order_status === self::STATUS_CANCELLED;
    }

    // Accessors
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'warning',
            'processing' => 'info',
            'shipped' => 'primary',
            'delivered' => 'success',
            'cancelled' => 'danger'
        ];
        return $badges[$this->order_status] ?? 'secondary';
    }

    public function getPaymentStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'warning',
            'paid' => 'success',
            'failed' => 'danger',
            'refunded' => 'secondary'
        ];
        return $badges[$this->payment_status] ?? 'secondary';
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('order_status', 'pending');
    }

    public function scopeProcessing($query)
    {
        return $query->where('order_status', 'processing');
    }

    public function scopeDelivered($query)
    {
        return $query->where('order_status', 'delivered');
    }

    public function scopeCancelled($query)
    {
        return $query->where('order_status', 'cancelled');
    }
}
