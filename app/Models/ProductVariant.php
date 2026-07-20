<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductVariant extends Model
{
    use HasFactory;

        protected $fillable = [
        'product_id',
        'color',
        'size',
        'price',
        'stock',
        'image',
        'status'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'status' => 'boolean',
        'stock' => 'integer'
    ];

    // ============ RELATIONSHIPS ============

    /**
     * Get the product that owns this variant
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get all cart items for this variant
     */
    public function carts()
    {
        return $this->hasMany(Cart::class, 'variant_id');
    }

    /**
     * Get all order items for this variant
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'variant_id');
    }

    // ============ ACCESSORS ============

    /**
     * Get the full name (color + size) of the variant
     */
    public function getFullNameAttribute()
    {
        $name = '';
        if ($this->color) $name .= $this->color;
        if ($this->size) $name .= ' - ' . $this->size;
        return $name ?: 'Default';
    }

    /**
     * Check if variant is in stock
     */
    public function getIsInStockAttribute()
    {
        return $this->stock > 0 && $this->status;
    }

    /**
     * Get formatted price
     */
   public function getFormattedPriceAttribute()
{
    return 'Rs. ' . number_format($this->price ?? 0, 2);
}

    /**
     * Get stock status label
     */
    public function getStockStatusAttribute()
    {
        if ($this->stock > 0 && $this->status) {
            return 'In Stock';
        } elseif ($this->stock <= 0 && $this->status) {
            return 'Out of Stock';
        } else {
            return 'Inactive';
        }
    }

    /**
     * Get stock status color
     */
    public function getStockStatusColorAttribute()
    {
        if ($this->stock > 0 && $this->status) {
            return 'success';
        } elseif ($this->stock <= 0 && $this->status) {
            return 'danger';
        } else {
            return 'secondary';
        }
    }

    // ============ SCOPES ============

    /**
     * Scope a query to only include active variants
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    /**
     * Scope a query to only include inactive variants
     */
    public function scopeInactive($query)
    {
        return $query->where('status', false);
    }

    /**
     * Scope a query to only include variants in stock
     */
    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0)->where('status', true);
    }

    /**
     * Scope a query to only include variants out of stock
     */
    public function scopeOutOfStock($query)
    {
        return $query->where('stock', '<=', 0);
    }

    /**
     * Scope a query to filter by color
     */
    public function scopeByColor($query, $color)
    {
        return $query->where('color', $color);
    }

    /**
     * Scope a query to filter by size
     */
    public function scopeBySize($query, $size)
    {
        return $query->where('size', $size);
    }

    // ============ HELPER METHODS ============

    /**
     * Decrease stock when variant is ordered
     */
    public function decreaseStock($quantity)
    {
        if ($this->stock < $quantity) {
            throw new \Exception('Insufficient stock for this variant. Available: ' . $this->stock);
        }

        $this->stock -= $quantity;
        $this->save();

        return $this;
    }

    /**
     * Increase stock when variant is restocked
     */
    public function increaseStock($quantity)
    {
        $this->stock += $quantity;
        $this->save();

        return $this;
    }

    /**
     * Check if variant has sufficient stock
     */
    public function hasSufficientStock($quantity)
    {
        return $this->stock >= $quantity && $this->status;
    }

    /**
     * Toggle variant status
     */
    public function toggleStatus()
    {
        $this->status = !$this->status;
        $this->save();

        return $this;
    }

    /**
     * Get the display name with stock info
     */
    public function getDisplayNameAttribute()
    {
        $name = $this->full_name;
        $stock = $this->is_in_stock ? '✓ In Stock' : '✗ Out of Stock';
        return "{$name} - {$stock}";
    }
}
