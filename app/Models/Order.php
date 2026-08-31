<?php

namespace App\Models;

use App\Models\Address;
use App\Models\Coupon;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\RewardTransaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    // ==================== CONSTANTS ====================
    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_SHIPPED = 'shipped';
    const STATUS_DELIVERED = 'delivered';
    const STATUS_CANCELLED = 'cancelled';

    const PAYMENT_PENDING = 'pending';
    const PAYMENT_PAID = 'paid';
    const PAYMENT_FAILED = 'failed';
    const PAYMENT_REFUNDED = 'refunded';

    // ==================== FILLABLE ====================
    protected $fillable = [
        'user_id',
        'address_id',
        'coupon_id',
        'order_number',
        'subtotal',
        'discount',
        'delivery_charge',
        'tax',
        'tax_percentage',
        'grand_total',
        'payment_method',
        'payment_status',
        'order_status',
        'transaction_id',
        'notes',
        'current_location',
        'shipped_at',
        'delivered_at',
        'tracking_number',
        'courier_name',
        'delivery_status',
        'delivery_notes',
        'estimated_delivery',
    ];

    // ==================== CASTS ====================
    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'delivery_charge' => 'decimal:2',
        'tax' => 'decimal:2',
        'tax_percentage' => 'decimal:2',
        'grand_total' => 'decimal:2',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ==================== CUSTOM PROPERTIES ====================
    public ?string $trackingNote = null;

    // ==================== RELATIONSHIPS ====================
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class)->withDefault();
    }

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function rewardTransaction(): HasOne
    {
        return $this->hasOne(RewardTransaction::class);
    }

    // ✅ Tracking Relationship
    public function trackings(): HasMany
    {
        return $this->hasMany(OrderTracking::class)->orderByDesc('status_date');
    }

    public function latestTracking()
    {
        return $this->hasOne(OrderTracking::class)->latest('status_date');
    }

    // ==================== STATUS HELPERS ====================
    public function isPending(): bool
    {
        return $this->order_status === self::STATUS_PENDING;
    }

    public function isProcessing(): bool
    {
        return $this->order_status === self::STATUS_PROCESSING;
    }

    public function isShipped(): bool
    {
        return $this->order_status === self::STATUS_SHIPPED;
    }

    public function isDelivered(): bool
    {
        return $this->order_status === self::STATUS_DELIVERED;
    }

    public function isCancelled(): bool
    {
        return $this->order_status === self::STATUS_CANCELLED;
    }

    // ==================== ACCESSORS ====================
    public function getStatusLabelAttribute(): string
    {
        return match ($this->order_status) {
            'pending' => 'Pending',
            'processing' => 'Processing',
            'shipped' => 'Shipped',
            'out_for_delivery' => 'Out for Delivery',
            'delivered' => 'Delivered',
            'cancelled' => 'Cancelled',
            'returned' => 'Returned',
            default => ucfirst($this->order_status ?? 'Unknown'),
        };
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->order_status) {
            'pending' => 'warning',
            'processing' => 'info',
            'shipped' => 'primary',
            'out_for_delivery' => 'info',
            'delivered' => 'success',
            'cancelled' => 'danger',
            'returned' => 'secondary',
            default => 'secondary',
        };
    }

    public function getPaymentStatusBadgeAttribute(): string
    {
        return match ($this->payment_status) {
            'pending' => 'warning',
            'paid' => 'success',
            'failed' => 'danger',
            'refunded' => 'secondary',
            default => 'secondary',
        };
    }

    // ✅ Current delivery status (from latest tracking)
    public function getCurrentStatusAttribute(): string
    {
        return $this->latestTracking?->status ?? $this->order_status ?? 'pending';
    }

    // ==================== SCOPES ====================
    public function scopePending($query)
    {
        return $query->where('order_status', 'pending');
    }

    public function scopeProcessing($query)
    {
        return $query->where('order_status', 'processing');
    }

    public function scopeShipped($query)
    {
        return $query->where('order_status', 'shipped');
    }

    public function scopeDelivered($query)
    {
        return $query->where('order_status', 'delivered');
    }

    public function scopeCancelled($query)
    {
        return $query->where('order_status', 'cancelled');
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // ==================== HELPERS ====================
    public function getOrderTotal(): float
    {
        return (float) $this->grand_total;
    }

    public function getItemCount(): int
    {
        return $this->items()->count();
    }

    public function canBeCancelled(): bool
    {
        return in_array($this->order_status, ['pending', 'processing']);
    }

    public function canBeShipped(): bool
    {
        return $this->order_status === 'processing';
    }

    public function canBeDelivered(): bool
    {
        return $this->order_status === 'shipped';
    }
}
