<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
      protected $fillable = [
        'product_id', 'color', 'size', 'price', 'stock', 'image', 'status'
    ];

    protected $casts = [
        'price' => 'decimal:2'
    ];

    // Relationships
    public function product()
    {
        return $this->belongsTo(ProductImage::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class, 'variant_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem    ::class, 'variant_id');
    }

    // Accessors
    public function getFullNameAttribute()
    {
        $name = '';
        if ($this->color) $name .= $this->color;
        if ($this->size) $name .= ' - ' . $this->size;
        return $name;
    }

    public function getIsInStockAttribute()
    {
        return $this->stock > 0 && $this->status;
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }
}
