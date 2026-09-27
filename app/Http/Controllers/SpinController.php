<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\UserReward;
use App\Models\SpinAttempt;
use App\Models\SpinReward;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SpinController extends Controller
{
    /**
     * Spin the wheel and select a reward.
     */
    public function spin(Request $request): JsonResponse
    {
        $user = $request->user();

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'Please login first to spin the wheel.',
            ], 401);
        }

        

        return DB::transaction(function () use ($user) {

            $rewards = SpinReward::query()
                ->where('status', true)
                ->where('probability', '>', 0)
                ->where(function ($query) {
                    $query->whereNull('stock')
                        ->orWhere('stock', '>', 0);
                })
                ->orderBy('id')
                ->lockForUpdate()
                ->get();

            if ($rewards->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No Spin & Win rewards are currently available.',
                ], 422);
            }

            $totalProbability = $rewards->sum(
                fn($reward) => (float) $reward->probability
            );

            if ($totalProbability <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Spin rewards are not configured correctly.',
                ], 422);
            }

            /*
        |--------------------------------------------------------------------------
        | Secure random selection
        |--------------------------------------------------------------------------
        */

            $random =
                random_int(1, 1_000_000) / 1_000_000;

            $randomPoint =
                $random * $totalProbability;


            $currentPoint = 0;

            $winner = null;

            $winnerIndex = 0;


            foreach ($rewards as $index => $reward) {

                $currentPoint +=
                    (float) $reward->probability;


                if ($randomPoint <= $currentPoint) {

                    $winner = $reward;

                    $winnerIndex = $index;

                    break;
                }
            }


            /*
        |--------------------------------------------------------------------------
        | Fallback
        |--------------------------------------------------------------------------
        */

            if (! $winner) {

                $winner =
                    $rewards->last();

                $winnerIndex =
                    $rewards->count() - 1;
            }


            /*
        |--------------------------------------------------------------------------
        | Stock
        |--------------------------------------------------------------------------
        */

            if ($winner->stock !== null) {

                $winner->decrement('stock');
            }


            /*
        |--------------------------------------------------------------------------
        | Spin attempt
        |--------------------------------------------------------------------------
        */

            $attempt =
                SpinAttempt::create([
                    'user_id' =>
                    $user->id,

                    'spin_reward_id' =>
                    $winner->id,

                    'reward_name' =>
                    $winner->name,

                    'status' =>
                    'won',
                ]);


            return response()->json([

                'success' =>
                true,

                'attempt_id' =>
                $attempt->id,

                'reward_index' =>
                $winnerIndex,

                'reward' => [

                    'id' =>
                    $winner->id,

                    'name' =>
                    $winner->name,

                    'type' =>
                    $winner->type,

                    'discount_percent' =>
                    $winner->discount_percent,

                    'coins' =>
                    $winner->coins,

                    'description' =>
                    $winner->description,
                ],
            ]);
        });
    }


    /**
     * Claim the selected reward.
     *
     * Coupon and coin integration should use the
     * existing project systems.
     */
    public function claim(Request $request): JsonResponse
    {
        $user = $request->user();

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'Please login first.',
            ], 401);
        }

        $request->validate([
            'attempt_id' => ['required', 'integer'],
        ]);

        return DB::transaction(function () use ($request, $user) {

            $attempt = SpinAttempt::query()
                ->where('id', $request->attempt_id)
                ->where('user_id', $user->id)
                ->lockForUpdate()
                ->first();

            if (! $attempt) {
                return response()->json([
                    'success' => false,
                    'message' => 'Spin attempt not found.',
                ], 404);
            }

            /*
             * Prevent double claiming.
             */
            if ($attempt->status !== 'won') {
                return response()->json([
                    'success' => false,
                    'message' => 'This reward has already been claimed.',
                ], 422);
            }

            $reward = SpinReward::query()
                ->lockForUpdate()
                ->find($attempt->spin_reward_id);

            if (! $reward) {
                return response()->json([
                    'success' => false,
                    'message' => 'Reward not found.',
                ], 404);
            }


            /*
                * --------------------------------------------------
                * DISCOUNT → COUPON
                * --------------------------------------------------
                */
            if ($reward->type === 'discount') {

                // Generate a unique coupon code
                $couponCode = 'SPIN-' . strtoupper(\Illuminate\Support\Str::random(8));

                while (Coupon::where('code', $couponCode)->exists()) {
                    $couponCode = 'SPIN-' . strtoupper(\Illuminate\Support\Str::random(8));
                }

                // Create a one-time percentage coupon
                $coupon = Coupon::create([
                    'code' => $couponCode,
                    'type' => 'percentage',
                    'amount' => $reward->discount_percent,
                    'minimum_amount' => null,
                    'maximum_discount' => null,
                    'usage_limit' => 1,
                    'used' => 0,
                    'start_date' => now(),
                    'expire_date' => now()->addDays(30),
                    'status' => true,
                ]);

                // Save reward history
                UserReward::create([
                    'user_id' => $user->id,
                    'spin_reward_id' => $reward->id,
                    'spin_attempt_id' => $attempt->id,
                    'reward_name' => $reward->name,
                    'reward_type' => 'discount',
                    'coins' => null,
                    'status' => 'claimed',
                    'claimed_at' => now(),
                ]);

                // Mark spin attempt as claimed
                $attempt->update([
                    'status' => 'claimed',
                    'claimed_at' => now(),
                ]);

                return response()->json([
                    'success' => true,
                    'message' => $reward->discount_percent . '% discount coupon added to your account.',
                    'redirect_url' => route('user.coupons'),
                    'reward' => [
                        'name' => $reward->name,
                        'type' => 'discount',
                        'discount_percent' => $reward->discount_percent,
                        'coupon_code' => $coupon->code,
                        'expire_date' => $coupon->expire_date?->format('d M Y'),
                    ],
                ]);
            }


            /*
 * --------------------------------------------------
 * COINS
 * --------------------------------------------------
 */
            if ($reward->type === 'coins') {

                $coins = (int) $reward->coins;

                if ($coins <= 0) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid coin reward amount.',
                    ], 422);
                }

                // Add coins to user's existing coin system
                $user->addCoins(
                    $coins,
                    null,
                    "Earned {$coins} coins from Spin & Win"
                );

                // Save reward history
                UserReward::create([
                    'user_id' => $user->id,
                    'spin_reward_id' => $reward->id,
                    'spin_attempt_id' => $attempt->id,
                    'reward_name' => $reward->name,
                    'reward_type' => 'coins',
                    'coins' => $coins,
                    'status' => 'claimed',
                    'claimed_at' => now(),
                ]);

                // Mark spin attempt as claimed
                $attempt->update([
                    'status' => 'claimed',
                    'claimed_at' => now(),
                ]);

                return response()->json([
                    'success' => true,
                    'message' => number_format($coins) . ' coins added to your account.',
                    'redirect_url' => route('user.dashboard'),
                    'reward' => [
                        'name' => $reward->name,
                        'type' => 'coins',
                        'coins' => $coins,
                    ],
                ]);
            }


            /*
             * --------------------------------------------------
             * GIFT
             * --------------------------------------------------
             */
            if ($reward->type === 'gift') {

                $userReward = \App\Models\UserReward::create([
                    'user_id' => $user->id,
                    'spin_reward_id' => $reward->id,
                    'spin_attempt_id' => $attempt->id,
                    'reward_name' => $reward->name,
                    'reward_type' => 'gift',
                    'status' => 'claimed',
                    'claimed_at' => now(),
                ]);

                $attempt->update([
                    'status' => 'claimed',
                    'claimed_at' => now(),
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Gift reward claimed successfully.',
                    'reward' => [
                        'name' => $reward->name,
                        'type' => $reward->type,
                    ],
                ]);
            }


            return response()->json([
                'success' => false,
                'message' => 'Invalid reward type.',
            ], 422);
        });
    }
}
