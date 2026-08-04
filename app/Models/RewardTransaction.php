<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RewardTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_id',
        'points',
        'type',
        'remarks'
    ];

    protected $casts = [
        'points' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    //  RELATIONSHIPS 

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    //  ACCESSORS 

    public function getTypeLabelAttribute()
    {
        return $this->type === 'earned' ? 'Earned' : 'Redeemed';
    }

    public function getTypeBadgeAttribute()
    {
        return $this->type === 'earned' ? 'success' : 'danger';
    }

    public function getTypeIconAttribute()
    {
        return $this->type === 'earned' ? '↑' : '↓';
    }

    public function getPointsDisplayAttribute()
    {
        $prefix = $this->type === 'earned' ? '+' : '-';
        return $prefix . $this->points;
    }

    public function getCustomerNameAttribute()
    {
        return $this->user?->name ?? 'Guest';
    }

    public function getOrderNumberAttribute()
    {
        return $this->order?->order_number ?? 'N/A';
    }

    public function getFormattedPointsAttribute()
    {
        return number_format($this->points) . ' pts';
    }

    //  SCOPES 

    public function scopeEarned($query)
    {
        return $query->where('type', 'earned');
    }

    public function scopeRedeemed($query)
    {
        return $query->where('type', 'redeemed');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('created_at', now()->month)
                     ->whereYear('created_at', now()->year);
    }

    //  HELPER METHODS 

    public static function getTotalPoints($userId)
    {
        $earned = self::where('user_id', $userId)->where('type', 'earned')->sum('points');
        $redeemed = self::where('user_id', $userId)->where('type', 'redeemed')->sum('points');
        return $earned - $redeemed;
    }

    public static function getEarnedPoints($userId)
    {
        return self::where('user_id', $userId)->where('type', 'earned')->sum('points');
    }

    public static function getRedeemedPoints($userId)
    {
        return self::where('user_id', $userId)->where('type', 'redeemed')->sum('points');
    }
}
