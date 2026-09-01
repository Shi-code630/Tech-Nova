<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderTracking extends Model
{
    protected $fillable = [
        'order_id',
        'status',
        'location',
        'note',
        'tracked_at',
    ];

     protected $casts = [
        'tracked_at' => 'datetime',
        'status_date' => 'datetime', 
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Order Placed',
            'processing' => 'Processing',
            'shipped' => 'Shipped',
            'delivered' => 'Delivered',
            'cancelled' => 'Cancelled',
            default => ucfirst($this->status),
        };
    }
}
