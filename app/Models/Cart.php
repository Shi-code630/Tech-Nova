<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'variant_id',
        'quantity',
        'price'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer'
    ];

    //  RELATIONSHIPS

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    //  ACCESSORS

    public function getSubtotalAttribute()
    {
        return $this->price * $this->quantity;
    }

    public function getFormattedSubtotalAttribute()
    {
        return 'Rs. ' . number_format($this->subtotal, 2);
    }

    public function getFormattedPriceAttribute()
    {
        return 'Rs. ' . number_format($this->price, 2);
    }

    public function getVariantNameAttribute()
    {
        if ($this->variant) {
            $name = '';
            if ($this->variant->color) {
                $name .= $this->variant->color;
            }
            if ($this->variant->size) {
                $name .= $name ? ' - ' . $this->variant->size : $this->variant->size;
            }
            return $name ?: 'Default';
        }
        return 'Standard';
    }

    public function getProductNameAttribute()
    {
        return $this->product?->name ?? 'Product Not Found';
    }

    public function getCustomerNameAttribute()
    {
        return $this->user?->name ?? 'Guest';
    }
}
