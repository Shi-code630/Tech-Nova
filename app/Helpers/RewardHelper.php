<?php

namespace App\Helpers;

use App\Models\User;
use App\Models\RewardSetting;

class RewardHelper
{
    /**
     * Rs. per 1 coin earned
     * Default: Rs.100 खर्च गर्दा 1 coin
     */
    public static function getEarnRate(): int
    {
        return (int) RewardSetting::get('earn_rate', 100);
    }

    /**
     * Coins per Rs.1 discount
     * Default: 20 coins = Rs.1
     */
    
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

        if ($rate <= 0 || $amount <= 0) {
            return 0;
        }

        return (int) floor($amount / $rate);
    }

    public static function calculateDiscount($points): float
    {
        $rate = self::getRedeemRate();
        $points = (int) ($points ?? 0);

        if ($rate <= 0 || $points <= 0) {
            return 0.0;
        }

        return round($points / $rate, 2);
    }


    public static function getMaxRedeemCoins(User $user, $subtotal): int
    {
        $available = (int) ($user->reward_points ?? 0);

        if ($available <= 0 || $subtotal <= 0) {
            return 0;
        }

        $maxPercent = self::getMaxDiscountPercent();
        $redeemRate = self::getRedeemRate();

        if ($redeemRate <= 0 || $maxPercent <= 0) {
            return 0;
        }

        // Max discount Rs. (e.g. 10% of 1000 = Rs. 100)
        $maxDiscountAmount = $subtotal * ($maxPercent / 100);

        // Max coins needed for that discount (100 * 20 = 2000 coins)
        // floor() use गर्नुहोस् ताकि maxPercent भन्दा बढी discount नहोस्
        $maxCoinsByDiscount = (int) floor($maxDiscountAmount * $redeemRate);

        return (int) min($available, $maxCoinsByDiscount);
    }

    /**

     */
    public static function getUserCoinsSummary(User $user): array
    {
        $available = (int) ($user->reward_points ?? 0);

        $totalEarned = (int) ($user->rewardTransactions()
            ->where('type', 'earned')
            ->sum('points') ?? 0);

        $totalRedeemed = (int) ($user->rewardTransactions()
            ->where('type', 'redeemed')
            ->sum('points') ?? 0);

        return [
            'available' => $available,
            'value' => self::calculateDiscount($available),
            'total_earned' => $totalEarned,
            'total_redeemed' => $totalRedeemed,
            'earn_rate' => self::getEarnRate(),
            'redeem_rate' => self::getRedeemRate(),
            'max_discount_percent' => self::getMaxDiscountPercent(),
        ];
    }

    /**
     * Recent transactions
     */
    public static function getRecentTransactions(User $user, $limit = 5)
    {
        return $user->rewardTransactions()
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}
