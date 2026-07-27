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
        return $this->status;
    }

    // ============ SCOPES ============

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
