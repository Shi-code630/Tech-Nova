<?php

namespace App\Models;

use App\Models\Address;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'reward_points',
        'status'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'status' => 'boolean',
        'reward_points' => 'integer'
    ];

    // ============ RELATIONSHIPS ============

    /**
     * Get all addresses for the user
     */
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    /**
     * Get the user's default address
     */
    public function defaultAddress()
    {
        return $this->hasOne(Address::class)->where('is_default', true);
    }

    /**
     * Get all cart items for the user
     */
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Get all wishlist items for the user
     */
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    /**
     * Get all orders for the user
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get all reviews by the user
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get all reward transactions for the user
     */
    public function rewardTransactions()
    {
        return $this->hasMany(RewardTransaction::class);
    }

    // ============ ACCESSORS ============

    /**
     * Get the user's full name (already name field)
     */
    public function getFullNameAttribute()
    {
        return $this->name;
    }

    /**
     * Get the user's first name
     */
    public function getFirstNameAttribute()
    {
        $nameParts = explode(' ', $this->name);
        return $nameParts[0] ?? $this->name;
    }

    /**
     * Get the user's last name
     */
    public function getLastNameAttribute()
    {
        $nameParts = explode(' ', $this->name);
        return end($nameParts) ?? $this->name;
    }

    /**
     * Check if user has sufficient reward points
     */
    public function hasSufficientPoints($points)
    {
        return $this->reward_points >= $points;
    }

    /**
     * Get the user's reward points formatted
     */
    public function getFormattedRewardPointsAttribute()
    {
        return number_format($this->reward_points);
    }

    /**
     * Get user's total order count
     */
    public function getOrderCountAttribute()
    {
        return $this->orders()->count();
    }

    /**
     * Get user's total spent
     */
    public function getTotalSpentAttribute()
    {
        return $this->orders()
            ->where('order_status', 'delivered')
            ->sum('grand_total');
    }

    /**
     * Get user's pending orders count
     */
    public function getPendingOrdersCountAttribute()
    {
        return $this->orders()
            ->whereIn('order_status', ['pending', 'processing'])
            ->count();
    }

    /**
     * Check if user is active
     */
    public function getIsActiveAttribute()
    {
        return $this->status === true;
    }

    /**
     * Get user's cart total
     */
    public function getCartTotalAttribute()
    {
        return $this->carts()->sum('price'); // Fixed: carts() instead of carts()
    }

    /**
     * Get user's cart items count
     */
    public function getCartCountAttribute()
    {
        return $this->carts()->count(); // Fixed: carts() instead of carts()
    }

    // ============ MUTATORS ============

    /**
     * Hash the password when setting
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * Format phone number before saving
     */
    public function setPhoneAttribute($value)
    {
        $this->attributes['phone'] = preg_replace('/[^0-9+]/', '', $value);
    }

    // ============ REWARD POINT METHODS ============

    /**
     * Add reward points to user
     */
    public function addRewardPoints($points, $remarks = null, $orderId = null)
    {
        $this->reward_points += $points;
        $this->save();

        // Create reward transaction record
        $this->rewardTransactions()->create([
            'points' => $points,
            'type' => 'earned',
            'order_id' => $orderId,
            'remarks' => $remarks
        ]);

        return $this;
    }

    /**
     * Redeem reward points from user
     */
    public function redeemRewardPoints($points, $remarks = null, $orderId = null)
    {
        if (!$this->hasSufficientPoints($points)) {
            throw new \Exception('Insufficient reward points. You have ' . $this->reward_points . ' points.');
        }

        $this->reward_points -= $points;
        $this->save();

        // Create reward transaction record
        $this->rewardTransactions()->create([
            'points' => $points,
            'type' => 'redeemed',
            'order_id' => $orderId,
            'remarks' => $remarks
        ]);

        return $this;
    }

    /**
     * Get points value in currency (if 1 point = Rs. 1)
     */
    public function getPointsValueAttribute()
    {
        return $this->reward_points;
    }

    // ============ SCOPES ============

    /**
     * Scope query to only include active users
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    /**
     * Scope query to only include inactive users
     */
    public function scopeInactive($query)
    {
        return $query->where('status', false);
    }

    /**
     * Scope query to only include users with minimum reward points
     */
    public function scopeWithMinRewardPoints($query, $points)
    {
        return $query->where('reward_points', '>=', $points);
    }

    /**
     * Scope query to only include users with maximum reward points
     */
    public function scopeWithMaxRewardPoints($query, $points)
    {
        return $query->where('reward_points', '<=', $points);
    }

    /**
     * Search users by name or email
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'LIKE', "%{$search}%")
            ->orWhere('email', 'LIKE', "%{$search}%")
            ->orWhere('phone', 'LIKE', "%{$search}%");
    }

    /**
     * Scope users who have placed orders
     */
    public function scopeHasOrders($query)
    {
        return $query->has('orders');
    }

    /**
     * Scope users who haven't placed orders
     */
    public function scopeNoOrders($query)
    {
        return $query->doesntHave('orders');
    }

    /**
     * Scope users by date range
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    // ============ HELPER METHODS ============

    /**
     * Check if user is a new customer (no orders)
     */
    public function isNewCustomer()
    {
        return $this->orders()->count() === 0;
    }

    /**
     * Get user's wishlist product IDs
     */
    public function getWishlistProductIds()
    {
        return $this->wishlists()->pluck('product_id')->toArray();
    }

    /**
     * Check if product is in user's wishlist
     */
    public function hasInWishlist($productId)
    {
        return $this->wishlists()->where('product_id', $productId)->exists();
    }

    /**
     * Toggle product in wishlist
     */
    public function toggleWishlist($productId)
    {
        if ($this->hasInWishlist($productId)) {
            $this->wishlists()->where('product_id', $productId)->delete();
            return false;
        } else {
            $this->wishlists()->create(['product_id' => $productId]);
            return true;
        }
    }

    /**
     * Get user's total reward points earned
     */
    public function getTotalPointsEarnedAttribute()
    {
        return $this->rewardTransactions()
            ->where('type', 'earned')
            ->sum('points');
    }

    /**
     * Get user's total points redeemed
     */
    public function getTotalPointsRedeemedAttribute()
    {
        return $this->rewardTransactions()
            ->where('type', 'redeemed')
            ->sum('points');
    }

    /**
     * Get user's recent orders
     */
    public function recentOrders($limit = 5)
    {
        return $this->orders()
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Get user's address count
     */
    public function getAddressCountAttribute()
    {
        return $this->addresses()->count();
    }

    public function returnRequests()
    {
        return $this->hasMany(ReturnRequest::class);
    }
}
