<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id', 'product_id', 'variant_id', 'quantity', 'price'
    ];

    protected $casts = [
        'price' => 'decimal:2'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variants()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    // Accessors
    public function getSubtotalAttribute()
    {
        return $this->price * $this->quantity;
    }

    public function getVariantNameAttribute()
    {
        if ($this->variant) {
            return $this->variant->full_name;
        }
        return null;
    }
}
