<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderTracking extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'order_id',
        'tracking_number',
        'courier_name',
        'status',
        'location',
        'note',
        'tracked_at',
        'status_date',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'tracked_at' => 'datetime',
        'status_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the order that owns the tracking.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get status label for display.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Pending',
            'processing' => 'Processing',
            'shipped' => 'Shipped',
            'out_for_delivery' => 'Out for Delivery',
            'delivered' => 'Delivered',
            'cancelled' => 'Cancelled',
            'returned' => 'Returned',
            default => ucfirst($this->status ?? 'Unknown'),
        };
    }

    /**
     * Get status badge color for Filament/UI.
     */
    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'warning',
            'processing' => 'info',
            'shipped' => 'primary',
            'out_for_delivery' => 'warning',
            'delivered' => 'success',
            'cancelled' => 'danger',
            'returned' => 'gray',
            default => 'secondary',
        };
    }

    /**
     * Get tracking number with prefix.
     */
    public function getFormattedTrackingNumberAttribute(): string
    {
        return $this->tracking_number ?: 'N/A';
    }

    /**
     * Get courier name with default.
     */
    public function getFormattedCourierAttribute(): string
    {
        return $this->courier_name ?: 'Not Assigned';
    }

    /**
     * Scope a query to only include pending tracking.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include delivered tracking.
     */
    public function scopeDelivered($query)
    {
        return $query->where('status', 'delivered');
    }

    /**
     * Scope a query to only include cancelled tracking.
     */
    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    /**
     * Scope a query for latest tracking.
     */
    public function scopeLatestFirst($query)
    {
        return $query->orderBy('status_date', 'desc');
    }
}
