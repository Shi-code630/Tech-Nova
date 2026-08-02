<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductVariant extends Model
{
    use HasFactory;

    protected $table = 'product_variants';

    protected $fillable = [
        'product_id',
        'color',
        'size',
        'price',
        'stock',
        'image',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
        'status' => 'boolean',
    ];

    // ============ RELATIONSHIPS ============

    /**
     * Get the product that owns this variant.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // ============ ACCESSORS ============

    /**
     * Get formatted price.
     */
    public function getFormattedPriceAttribute(): string
    {
        return 'Rs. ' . number_format($this->price, 2);
    }

    /**
     * Check if variant is active.
     */
    public function getIsActiveAttribute(): bool
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
    public function scopeSearchFullName($query, $search)
    {
        return $query->where('color', 'LIKE', "%{$search}%")
            ->orWhere('size', 'LIKE', "%{$search}%");
    }

    public function getFullNameSortableAttribute()
    {
        return $this->color . ' ' . $this->size;
    }

    //SCOPES

    /**
     * Scope a query to only include active variants.
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    /**
     * Scope a query to only include variants in stock.
     */
    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    // ============ HELPERS ============

    /**
     * Decrease stock when variant is ordered.
     */
    public function decreaseStock(int $quantity): bool
    {
        if ($this->stock < $quantity) {
            return false;
        }
        $this->stock -= $quantity;
        $this->save();
        return true;
    }

    /**
     * Increase stock when variant is restocked.
     */
    public function increaseStock(int $quantity): void
    {
        $this->stock += $quantity;
        $this->save();
    }
}
