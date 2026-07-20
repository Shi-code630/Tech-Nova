<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
     protected $fillable = [
        'order_id', 'product_id', 'variant_id', 'price', 'quantity', 'total'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'total' => 'decimal:2'
    ];

    // Relationships
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(ProductImage::class);
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    // Accessors
    public function getVariantNameAttribute()
    {
        if ($this->variant) {
            return $this->variant->full_name;
        }
        return 'Standard';
    }
}
