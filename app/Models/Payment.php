<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
     protected $fillable = [
        'order_id', 'payment_method', 'transaction_id', 'amount',
        'status', 'gateway_response'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'gateway_response' => 'array'
    ];

    // Relationships
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Accessors
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
}
