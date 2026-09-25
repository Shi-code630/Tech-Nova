<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\RewardHelper;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class KhaltiPaymentController extends Controller
{
    public function initiate(Request $request)
    {
        $user = $request->user();
        $checkout = session('checkout_confirmation');

        if (!$checkout) {
            return redirect()->route('checkout')
                ->with('error', 'Checkout session expired. Please try again.');
        }

        $address = $user->addresses()->find($checkout['address_id']);

        if (!$address) {
            return redirect()->route('checkout')
                ->with('error', 'Delivery address not found.');
        }

        $cartItems = $user->carts()->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('user.cart')
                ->with('error', 'Your cart is empty.');
        }

        // ✅ FRESH Calculate - session मा भरोसा नगर्नुहोस्
        $subtotal = $cartItems->sum(fn($item) => $item->price * $item->quantity);

        // Coupon - session बाट
        $couponDiscount = 0;
        $appliedCoupon = session('applied_coupon');

        if ($appliedCoupon && !empty($appliedCoupon['code'])) {
            try {
                $coupon = Coupon::findByCode($appliedCoupon['code']);
                if ($coupon) {
                    $result = $coupon->apply($subtotal);
                    if ($result['valid']) {
                        $couponDiscount = round($result['discount'], 2);
                    }
                }
            } catch (\Throwable $e) {
                Log::warning('Coupon re-validation failed: ' . $e->getMessage());
            }
        }

        // Coins - session बाट
        $redeemPoints = (int) ($checkout['redeem_points'] ?? 0);
        $pointsDiscount = 0;

        if ($redeemPoints > 0) {
            $pointsDiscount = RewardHelper::calculateDiscount($redeemPoints);
        }

        // Discount cap
        $discount = round($couponDiscount + $pointsDiscount, 2);
        if ($discount > $subtotal) {
            $discount = $subtotal;
        }

        // Delivery + Tax
        $isInsideValley = $this->isInsideKathmanduValley($address);
        $deliveryCharge = $this->calculateDeliveryCharge($subtotal, $isInsideValley);
        $tax = $subtotal * 0.13;

        // ✅ Final Amount
        $grandTotal = round($subtotal - $discount + $deliveryCharge + $tax, 2);

        // ✅ Session update - latest values
        $checkout['subtotal'] = $subtotal;
        $checkout['coupon_discount'] = $couponDiscount;
        $checkout['points_discount'] = $pointsDiscount;
        $checkout['discount'] = $discount;
        $checkout['delivery_charge'] = $deliveryCharge;
        $checkout['tax'] = $tax;
        $checkout['grand_total'] = $grandTotal;

        session()->put('checkout_confirmation', $checkout);

        Log::info('Khalti initiate amount', [
            'subtotal' => $subtotal,
            'coupon_discount' => $couponDiscount,
            'points_discount' => $pointsDiscount,
            'delivery' => $deliveryCharge,
            'tax' => $tax,
            'grand_total' => $grandTotal,
        ]);

        if ($grandTotal < 10) {
            return redirect()->route('checkout')
                ->with('error', 'Amount must be at least Rs. 10 for Khalti payment.');
        }

        $purchaseOrderId = 'TN-' . strtoupper(Str::random(10));
        session()->put('khalti_purchase_order_id', $purchaseOrderId);

        $payload = [
            'return_url' => route('khalti.callback'),
            'website_url' => config('app.url'),
            'amount' => (int) round($grandTotal * 100),  // ✅ Fresh amount
            'purchase_order_id' => $purchaseOrderId,
            'purchase_order_name' => 'Order ' . $purchaseOrderId,
            'customer_info' => [
                'name' => $user->name ?? 'Customer',
                'email' => $user->email ?? 'customer@example.com',
                'phone' => $user->phone ?? '9800000000',
            ],
        ];

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Key ' . config('services.khalti.secret_key'),
                'Content-Type' => 'application/json',
            ])->post(config('services.khalti.base_url') . '/epayment/initiate/', $payload);

            if (!$response->successful()) {
                Log::error('Khalti initiate failed', ['body' => $response->body()]);
                return redirect()->route('checkout')
                    ->with('error', 'Payment initialization failed. Please try again.');
            }

            $data = $response->json();
            session()->put('khalti_pidx', $data['pidx']);

            return redirect($data['payment_url']);

        } catch (\Throwable $e) {
            Log::error('Khalti initiate exception: ' . $e->getMessage());
            return redirect()->route('checkout')
                ->with('error', 'Payment gateway error. Please try again.');
        }
    }

    public function callback(Request $request)
    {
        $pidx = $request->query('pidx');

        if (!$pidx) {
            return redirect()->route('checkout')
                ->with('error', 'Invalid payment response.');
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Key ' . config('services.khalti.secret_key'),
            ])->post(config('services.khalti.base_url') . '/epayment/lookup/', [
                'pidx' => $pidx,
            ]);

            if (!$response->successful()) {
                Log::error('Khalti lookup failed', ['body' => $response->body()]);
                return redirect()->route('checkout')
                    ->with('error', 'Could not verify payment. Please contact support.');
            }

            $data = $response->json();

            if (($data['status'] ?? '') !== 'Completed') {
                return redirect()->route('checkout')
                    ->with('error', 'Payment was not completed. Status: ' . ($data['status'] ?? 'Unknown'));
            }

            $user = $request->user();
            $checkoutController = new CheckoutController();
            $order = $checkoutController->placeOrderAfterKhalti($user, $data);

            return redirect()->route('user.order.view', $order->id)
                ->with('success', 'Payment successful! Your order has been placed.');

        } catch (\Throwable $e) {
            Log::error('Khalti callback exception: ' . $e->getMessage());
            return redirect()->route('checkout')
                ->with('error', 'Payment verification error: ' . $e->getMessage());
        }
    }

    private function isInsideKathmanduValley($address): bool
    {
        if (!$address) return false;

        $valleyDistricts = ['kathmandu', 'lalitpur', 'bhaktapur'];
        $valleyCities = ['kathmandu', 'lalitpur', 'bhaktapur', 'patan', 'kirtipur', 'madhyapur thimi'];

        $district = strtolower($address->district ?? '');
        $city = strtolower($address->city ?? '');

        foreach ($valleyDistricts as $vd) {
            if (str_contains($district, $vd)) return true;
        }
        foreach ($valleyCities as $vc) {
            if (str_contains($city, $vc)) return true;
        }

        return false;
    }

    private function calculateDeliveryCharge(float $subtotal, bool $isInsideValley): float
    {
        $tiers = $isInsideValley ? [
            10000 => 0, 5000 => 80, 2000 => 100, 1000 => 120, 0 => 150,
        ] : [
            10000 => 100, 5000 => 200, 2000 => 300, 1000 => 400, 0 => 500,
        ];

        foreach ($tiers as $threshold => $charge) {
            if ($subtotal >= $threshold) return $charge;
        }

        return end($tiers);
    }
}
