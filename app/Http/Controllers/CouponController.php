<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $usedCouponIds = $user->orders()
            ->whereNotNull('coupon_id')
            ->where('order_status', '!=', 'cancelled')
            ->pluck('coupon_id');

        $available = Coupon::valid()
            ->latest()
            ->get()
            ->filter(fn (Coupon $coupon) => !$usedCouponIds->contains($coupon->id))
            ->values();

        $used = Coupon::whereIn('id', $usedCouponIds)->latest()->get();

        return view('user.coupons.index', compact('available', 'used'));
    }

    public function apply(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50',
        ]);

        $user = $request->user();
        $subtotal = $user->carts()->get()->sum(fn ($item) => $item->price * $item->quantity);

        if ($subtotal <= 0) {
            return $this->couponResponse($request, false, 'Add items to your cart before applying a coupon.');
        }

        $result = $this->validateCoupon($user, $validated['code'], $subtotal);

        if (!$result['valid']) {
            return $this->couponResponse($request, false, $result['message']);
        }

        $coupon = $result['coupon'];

        session()->put('applied_coupon', [
            'id' => $coupon->id,
            'code' => $coupon->code,
            'type' => $coupon->type,
            'discount' => $result['discount'],
        ]);

        return $this->couponResponse(
            $request,
            true,
            'Coupon ' . $coupon->code . ' applied. You saved Rs. ' . number_format($result['discount'], 2) . '.',
            [
                'code' => $coupon->code,
                'discount' => round($result['discount'], 2),
                'label' => $coupon->discount_formatted,
            ]
        );
    }

    public function remove(Request $request)
    {
        session()->forget('applied_coupon');

        return $this->couponResponse($request, true, 'Coupon removed.');
    }

    private function validateCoupon($user, string $code, float $subtotal): array
    {
        $coupon = Coupon::findByCode($code);

        if (!$coupon) {
            return ['valid' => false, 'message' => 'Invalid coupon code.'];
        }

        $alreadyUsed = $user->orders()
            ->where('coupon_id', $coupon->id)
            ->where('order_status', '!=', 'cancelled')
            ->exists();

        if ($alreadyUsed) {
            return ['valid' => false, 'message' => 'You have already used this coupon.'];
        }

        $result = $coupon->apply($subtotal);

        if (!$result['valid']) {
            return ['valid' => false, 'message' => $result['message']];
        }

        return [
            'valid' => true,
            'coupon' => $coupon,
            'discount' => $result['discount'],
            'message' => $result['message'],
        ];
    }

    private function couponResponse(Request $request, bool $success, string $message, array $extra = [])
    {
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(array_merge([
                'success' => $success,
                'message' => $message,
            ], $extra), $success ? 200 : 422);
        }

        $redirect = redirect()->back();

        return $success
            ? $redirect->with('success', $message)
            : $redirect->with('error', $message);
    }
}
