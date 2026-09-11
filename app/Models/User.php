<?php

namespace App\Models;

use App\Models\Address;
use App\Models\Wishlist;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'image',
        'password',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'status'           => 'boolean',
        'reward_points'    => 'integer',
    ];

    // =========================================================
    // RELATIONSHIPS
    // =========================================================\


    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function defaultAddress()
    {
        return $this->hasOne(Address::class)->where('is_default', true);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

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

    // =========================================================
    // ACCESSORS
    // =========================================================

    public function getFullNameAttribute()
    {
        return $this->name;
    }

    public function getFirstNameAttribute()
    {
        $parts = explode(' ', $this->name);
        return $parts[0] ?? $this->name;
    }

    public function getLastNameAttribute()
    {
        $parts = explode(' ', $this->name);
        return end($parts) ?? $this->name;
    }

    /**
     * Returns full public URL of profile image
     */
    public function getImageAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        // Already a full URL
        if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
            return $value;
        }

        return asset('storage/' . ltrim($value, '/'));
    }

    /**
     * Alias for image
     */
    public function getProfileImageUrlAttribute()
    {
        return $this->image;
    }

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

    public function getAvailableCoinsAttribute()
    {
        return $this->reward_points ?? 0;
    }

    public function getCoinsValueAttribute()
    {
        $rate = \App\Helpers\RewardHelper::getRedeemRate();

        return $rate > 0 ? $this->reward_points / $rate : 0;
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

    public function getTotalPointsEarnedAttribute()
    {
        return $this->total_coins_earned;
    }

    public function getTotalPointsRedeemedAttribute()
    {
        return $this->total_coins_redeemed;
    }

    public function getPointsValueAttribute()
    {
        return $this->reward_points;
    }

    public function getAddressCountAttribute()
    {
        return $this->addresses()->count();
    }

    // =========================================================
    // MUTATORS
    // =========================================================

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function setPhoneAttribute($value)
    {
        $this->attributes['phone'] = preg_replace('/[^0-9+]/', '', $value);
    }

    // =========================================================
    // REWARD METHODS
    // =========================================================

    public function addRewardPoints($points, $remarks = null, $orderId = null)
    {
        return DB::transaction(function () use ($points, $orderId, $remarks) {
            $user = static::query()->lockForUpdate()->findOrFail($this->id);

            $user->increment('reward_points', $points);
            $this->reward_points = $user->fresh()->reward_points;

            return $this->rewardTransactions()->create([
                'order_id' => $orderId,
                'points'   => $points,
                'type'     => 'earned',
                'remarks'  => $remarks ?? 'Coins earned from order',
            ]);
        });
    }

    public function redeemRewardPoints($points, $remarks = null, $orderId = null)
    {
        return DB::transaction(function () use ($points, $orderId, $remarks) {
            $user = static::query()->lockForUpdate()->findOrFail($this->id);

            if ($user->reward_points < $points) {
                throw new \Exception('Insufficient reward points. You have ' . $user->reward_points . ' points.');
            }

            $user->decrement('reward_points', $points);
            $this->reward_points = $user->fresh()->reward_points;

            return $this->rewardTransactions()->create([
                'order_id' => $orderId,
                'points'   => $points,
                'type'     => 'redeemed',
                'remarks'  => $remarks ?? 'Coins redeemed',
            ]);
        });
    }

    public function addCoins($points, $orderId = null, $remarks = null)
    {
        return $this->addRewardPoints($points, $remarks, $orderId);
    }

    public function redeemCoins($points, $orderId = null, $remarks = null)
    {
        return $this->redeemRewardPoints($points, $remarks, $orderId);
    }

    public function hasSufficientPoints($points): bool
    {
        return $this->reward_points >= $points;
    }

    public function hasEnoughCoins($points): bool
    {
        return $this->hasSufficientPoints($points);
    }

    // =========================================================
    // SCOPES
    // =========================================================

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeInactive($query)
    {
        return $query->where('status', false);
    }

    public function scopeWithMinRewardPoints($query, $points)
    {
        return $query->where('reward_points', '>=', $points);
    }

    public function scopeWithMaxRewardPoints($query, $points)
    {
        return $query->where('reward_points', '<=', $points);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%")
                ->orWhere('phone', 'LIKE', "%{$search}%");
        });
    }

    public function scopeHasOrders($query)
    {
        return $query->has('orders');
    }

    public function scopeNoOrders($query)
    {
        return $query->doesntHave('orders');
    }

    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    // =========================================================
    // HELPER METHODS
    // =========================================================

    public function isNewCustomer()
    {
        return $this->orders()->count() === 0;
    }

    public function getWishlistProductIds()
    {
        return $this->wishlists()->pluck('product_id')->toArray();
    }

    public function hasInWishlist($productId)
    {
        return $this->wishlists()->where('product_id', $productId)->exists();
    }

    public function toggleWishlist($productId)
    {
        if ($this->hasInWishlist($productId)) {
            $this->wishlists()->where('product_id', $productId)->delete();
            return false;
        }

        $this->wishlists()->create(['product_id' => $productId]);
        return true;
    }

    public function recentOrders($limit = 5)
    {
        return $this->orders()->latest()->limit($limit)->get();
    }
}
