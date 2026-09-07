<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReturnRequest extends Model
{
    public const TYPE_RETURN = 'return';
    public const TYPE_EXCHANGE = 'exchange';

    public const STATUS_REQUESTED = 'requested';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';
    public const STATUS_RECEIVED = 'received';
    public const STATUS_COMPLETED = 'completed';

    protected $fillable = [
        'order_id',
        'order_item_id',
        'user_id',
        'request_type',
        'exchange_variant_id',
        'quantity',
        'reason',
        'image',
        'status',
        'admin_note',
        'approved_at',
        'received_at',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'approved_at' => 'datetime',
            'received_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function exchangeVariant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'exchange_variant_id');
    }

    public function getRequestTypeLabelAttribute(): string
    {
        return $this->request_type === self::TYPE_EXCHANGE
            ? 'Exchange'
            : 'Return';
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_REQUESTED => 'Requested',
            self::STATUS_APPROVED => 'Approved',
            self::STATUS_REJECTED => 'Rejected',
            self::STATUS_RECEIVED => 'Received',
            self::STATUS_COMPLETED => 'Completed',
            default => 'Unknown',
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_REQUESTED => 'warning',
            self::STATUS_APPROVED => 'info',
            self::STATUS_REJECTED => 'danger',
            self::STATUS_RECEIVED => 'primary',
            self::STATUS_COMPLETED => 'success',
            default => 'secondary',
        };
    }
}
