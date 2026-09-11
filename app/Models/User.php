<?php

namespace App\Models;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Review;
use App\Models\RewardTransaction;
use App\Models\ReturnRequest;
use App\Models\Wishlist;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /*
    |--------------------------------------------------------------------------
    | Fillable
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'name',
        'email',
        'phone',
        'image',
        'password',
        'status',
    ];

    /*
    |--------------------------------------------------------------------------
    | Hidden
    |--------------------------------------------------------------------------
    */

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /*
    |--------------------------------------------------------------------------
    | Casts
    |--------------------------------------------------------------------------
    */

    protected $casts = [
        'email_verified_at' => 'datetime',
        'status' => 'boolean',
        'reward_points' => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    public function getFullNameAttribute()
    {
        return $this->name;
    }

    public function getFirstNameAttribute()
    {
        $nameParts = explode(' ', $this->name);

        return $nameParts[0] ?? $this->name;
    }

    public function getLastNameAttribute()
    {
        $nameParts = explode(' ', $this->name);

        return end($nameParts) ?? $this->name;
    }

    /*
    |--------------------------------------------------------------------------
    | Image Accessor
    |--------------------------------------------------------------------------
    */

    public function getImageAttribute($value)
    {
        if ($value && file_exists(public_path('storage/' . $value))) {
            return asset('storage/' . $value);
        }

        return null;
    }

    /*
    |--------------------------------------------------------------------------
    | Profile Image URL
    |--------------------------------------------------------------------------
    */

    public function getProfileImageUrlAttribute()
    {
        if ($this->image && file_exists(public_path('storage/' . $this->image))) {
            return asset('storage/' . $this->image);
        }

        return null;
    }

    /*
    |--------------------------------------------------------------------------
    | Reward / Order / Cart Accessors
    |--------------------------------------------------------------------------
    */

    public function getFormattedRewardPointsAttribute()
    {
        return number_format($this->reward_points);
    }

    public function getOrderCountAttribute()
    {
        return $this->orders()->count();
    }

    public function getTotalSpentAttribute()
    {
        return $this->orders()
            ->where('order_status', 'delivered')
            ->sum('grand_total');
    }

    public function getPendingOrdersCountAttribute()
    {
        return $this->orders()
            ->whereIn('order_status', ['pending', 'processing'])
            ->count();
    }

    public function getIsActiveAttribute()
    {
        return $this->status === true;
    }

    public function getCartTotalAttribute()
    {
        return $this->carts()->sum('price');
    }

    public function getCartCountAttribute()
    {
        return $this->carts()->count();
    }

    /*
    |--------------------------------------------------------------------------
    | Coins Accessors
    |--------------------------------------------------------------------------
    */

    public function getAvailableCoinsAttribute()
    {
        return $this->reward_points ?? 0;
    }

    public function getCoinsValueAttribute()
    {
        $redeemRate = \App\Helpers\RewardHelper::getRedeemRate();

        return $redeemRate > 0
            ? $this->reward_points / $redeemRate
            : 0;
    }

    public function getTotalCoinsEarnedAttribute()
    {
        return $this->rewardTransactions()
            ->where('type', 'earned')
            ->sum('points');
    }

    public function getTotalCoinsRedeemedAttribute()
    {
        return $this->rewardTransactions()
            ->where('type', 'redeemed')
            ->sum('points');
    }

    /*
    |--------------------------------------------------------------------------
    | Backward Compatibility
    |--------------------------------------------------------------------------
    */

    public function getTotalPointsEarnedAttribute()
    {
        return $this->getTotalCoinsEarnedAttribute();
    }

    public function getTotalPointsRedeemedAttribute()
    {
        return $this->getTotalCoinsRedeemedAttribute();
    }

    public function getPointsValueAttribute()
    {
        return $this->reward_points;
    }

    public function getAddressCountAttribute()
    {
        return $this->addresses()->count();
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function setPhoneAttribute($value)
    {
        $this->attributes['phone'] = preg_replace(
            '/[^0-9+]/',
            '',
            $value
        );
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function defaultAddress()
    {
        return $this->hasOne(Address::class)
            ->where('is_default', true);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * User wishlists
     *
     * IMPORTANT:
     * The relationship name is "wishlists" (plural).
     */
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function rewardTransactions()
    {
        return $this->hasMany(RewardTransaction::class);
    }

    public function returnRequests()
    {
        return $this->hasMany(ReturnRequest::class);
    }

    /*
    |--------------------------------------------------------------------------
    | REWARD POINT METHODS
    |--------------------------------------------------------------------------
    */

    /**
     * Add reward points safely.
     */
    public function addRewardPoints(
        $points,
        $remarks = null,
        $orderId = null
    ) {
        return DB::transaction(function () use (
            $points,
            $orderId,
            $remarks
        ) {
            $user = static::query()
                ->lockForUpdate()
                ->findOrFail($this->id);

            $user->increment('reward_points', $points);

            // Keep current instance in sync
            $this->reward_points = $user->fresh()->reward_points;

            return $this->rewardTransactions()->create([
                'order_id' => $orderId,
                'points' => $points,
                'type' => 'earned',
                'remarks' => $remarks
                    ?? 'Coins earned from order',
            ]);
        });
    }

    /**
     * Redeem reward points safely.
     */
    public function redeemRewardPoints(
        $points,
        $remarks = null,
        $orderId = null
    ) {
        return DB::transaction(function () use (
            $points,
            $orderId,
            $remarks
        ) {
            $user = static::query()
                ->lockForUpdate()
                ->findOrFail($this->id);

            if ($user->reward_points < $points) {
                throw new \Exception(
                    'Insufficient reward points. You have '
                    . $user->reward_points
                    . ' points.'
                );
            }

            $user->decrement('reward_points', $points);

            $this->reward_points = $user->fresh()->reward_points;

            return $this->rewardTransactions()->create([
                'order_id' => $orderId,
                'points' => $points,
                'type' => 'redeemed',
                'remarks' => $remarks ?? 'Coins redeemed',
            ]);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | COINS ALIASES
    |--------------------------------------------------------------------------
    */

    public function addCoins(
        $points,
        $orderId = null,
        $remarks = null
    ) {
        return $this->addRewardPoints(
            $points,
            $remarks,
            $orderId
        );
    }

    public function redeemCoins(
        $points,
        $orderId = null,
        $remarks = null
    ) {
        return $this->redeemRewardPoints(
            $points,
            $remarks,
            $orderId
        );
    }

    public function hasSufficientPoints($points): bool
    {
        return $this->reward_points >= $points;
    }

    public function hasEnoughCoins($points): bool
    {
        return $this->hasSufficientPoints($points);
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeInactive($query)
    {
        return $query->where('status', false);
    }

    public function scopeWithMinRewardPoints(
        $query,
        $points
    ) {
        return $query->where(
            'reward_points',
            '>=',
            $points
        );
    }

    public function scopeWithMaxRewardPoints(
        $query,
        $points
    ) {
        return $query->where(
            'reward_points',
            '<=',
            $points
        );
    }

    public function scopeSearch($query, $search)
    {
        return $query
            ->where('name', 'LIKE', "%{$search}%")
            ->orWhere('email', 'LIKE', "%{$search}%")
            ->orWhere('phone', 'LIKE', "%{$search}%");
    }

    public function scopeHasOrders($query)
    {
        return $query->has('orders');
    }

    public function scopeNoOrders($query)
    {
        return $query->doesntHave('orders');
    }

    public function scopeDateRange(
        $query,
        $startDate,
        $endDate
    ) {
        return $query->whereBetween(
            'created_at',
            [$startDate, $endDate]
        );
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER METHODS
    |--------------------------------------------------------------------------
    */

    public function isNewCustomer()
    {
        return $this->orders()->count() === 0;
    }

    /**
     * Get all wishlist product IDs.
     */
    public function getWishlistProductIds()
    {
        return $this->wishlists()
            ->pluck('product_id')
            ->toArray();
    }

    /**
     * Check whether product is in wishlist.
     */
    public function hasInWishlist($productId)
    {
        return $this->wishlists()
            ->where('product_id', $productId)
            ->exists();
    }

    /**
     * Add/remove product from wishlist.
     */
    public function toggleWishlist($productId)
    {
        if ($this->hasInWishlist($productId)) {

            $this->wishlists()
                ->where('product_id', $productId)
                ->delete();

            return false;
        }

        $this->wishlists()->create([
            'product_id' => $productId,
        ]);

        return true;
    }

    public function recentOrders($limit = 5)
    {
        return $this->orders()
            ->latest()
            ->limit($limit)
            ->get();
    }
}
