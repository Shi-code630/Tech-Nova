<?php

namespace App\Helpers;

use App\Models\User;
use App\Models\RewardSetting;

class RewardHelper
{
   
    public static function getEarnRate(): int
    {
        return (int) RewardSetting::get('earn_rate', 100);
    }

    public static function getRedeemRate(): int
    {
        return (int) RewardSetting::get('redeem_rate', 20);
    }

    
    public static function getMaxDiscountPercent(): int
    {
        return (int) RewardSetting::get('max_discount_percent', 10);
    }

    public static function calculateEarnedCoins($amount): int
    {
        $rate = self::getEarnRate();

        
        if ($rate <= 0) {
            return 0;
        }

       
        return (int) floor($amount / $rate);
    }

        public static function calculateDiscount($points): float
    {
        $rate = self::getRedeemRate();

        if ($rate <= 0) {
            return 0.0;
        }

        return $points / $rate;
    }

  
    public static function getMaxRedeemCoins(User $user, $subtotal): int
    {
        $maxPercent = self::getMaxDiscountPercent();
        $maxDiscount = $subtotal * ($maxPercent / 100);
        $redeemRate = self::getRedeemRate();

       
        $maxPoints = $redeemRate > 0 ? (int) ceil($maxDiscount * $redeemRate) : 0;

       
        return min($user->reward_points ?? 0, $maxPoints);
    }

   
    public static function getUserCoinsSummary(User $user): array
    {
        $totalEarned = $user->rewardTransactions()->where('type', 'earned')->sum('points');
        $totalRedeemed = $user->rewardTransactions()->where('type', 'redeemed')->sum('points');

        return [
            'available' => $user->reward_points,
            'value' => self::calculateDiscount($user->reward_points),
            'total_earned' => $totalEarned,
            'total_redeemed' => $totalRedeemed,
            'earn_rate' => self::getEarnRate(),
            'redeem_rate' => self::getRedeemRate(),
            'max_discount_percent' => self::getMaxDiscountPercent(),
        ];
    }

   
    public static function getRecentTransactions(User $user, $limit = 5)
    {
        return $user->rewardTransactions()
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}