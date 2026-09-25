<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\OrderConfirmationMail;
use App\Helpers\RewardHelper;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Coupon;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $cartItems = $user->carts()->with(['product', 'variant'])->latest()->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('user.cart')->with('error', 'Your cart is empty.');
        }

        $subtotal = $cartItems->sum(fn($item) => $item->price * $item->quantity);
        $addresses = $user->addresses()->latest()->get();
        $defaultAddress = $addresses->where('is_default', true)->first();

        $isInsideValley = $this->isInsideKathmanduValley($defaultAddress);
        $deliveryCharge = $this->calculateDeliveryCharge($subtotal, $isInsideValley);
        $tax = $subtotal * 0.13;

        $coinSummary = RewardHelper::getUserCoinsSummary($user);
        $maxRedeemPoints = RewardHelper::getMaxRedeemCoins($user, $subtotal);
        $maxPointsDiscount = RewardHelper::calculateDiscount($maxRedeemPoints);

        if ($request->filled('coupon')) {
            $this->rememberCoupon($user, $request->coupon, $subtotal);
        }

        [$appliedCoupon, $couponDiscount] = $this->currentCoupon($user, $subtotal);

        return view('checkout.index', compact(
            'cartItems',
            'subtotal',
            'deliveryCharge',
            'tax',
            'addresses',
            'coinSummary',
            'maxRedeemPoints',
            'maxPointsDiscount',
            'isInsideValley',
            'appliedCoupon',
            'couponDiscount'
        ));
    }

    public function addresses(Request $request)
    {
        $addresses = $request->user()->addresses()->latest()->get();
        return view('user.addresses.index', compact('addresses'));
    }

    public function createAddress()
    {
        return view('checkout.address');
    }

    public function storeAddress(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'province' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'address' => 'required|string|max:500',
            'postal_code' => 'nullable|string|max:20',
        ]);

        $user = $request->user();
        $validated['user_id'] = $user->id;
        $validated['is_default'] = !$user->addresses()->exists();

        $address = Address::create($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Address saved successfully.',
                'address' => $address,
            ]);
        }

        $route = $request->input('from') === 'addresses' ? 'checkout.addresses' : 'checkout';
        return redirect()->route($route)->with('success', 'Address added successfully.');
    }

    public function editAddress(Request $request, $id)
    {
        $address = $request->user()->addresses()->where('id', $id)->firstOrFail();
        return view('checkout.address-edit', compact('address'));
    }

    public function updateAddress(Request $request, $id)
    {
        $address = $request->user()->addresses()->where('id', $id)->firstOrFail();

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'province' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'address' => 'required|string|max:500',
            'postal_code' => 'nullable|string|max:20',
        ]);

        $address->update($validated);

        return redirect()->route('checkout.addresses')->with('success', 'Address updated successfully.');
    }

    public function deleteAddress(Request $request, $id)
    {
        $address = $request->user()->addresses()->where('id', $id)->firstOrFail();
        $wasDefault = $address->is_default;

        $address->delete();

        if ($wasDefault) {
            $newDefault = $request->user()->addresses()->latest()->first();
            if ($newDefault) {
                $newDefault->update(['is_default' => true]);
            }
        }

        return redirect()->route('checkout.addresses')->with('success', 'Address deleted successfully.');
    }

    /**
     * ✅ Continue Checkout - COD र Khalti दुवैको लागि काम गर्छ
     */
    public function continueCheckout(Request $request)
    {
        $validated = $request->validate([
            'address_id' => 'required|exists:addresses,id',
            'payment_method' => 'required|in:cod,online',
            'redeem_points' => 'nullable|integer|min:0',
            'coupon_code' => 'nullable|string|max:50',
            'initiate_khalti' => 'nullable|in:1',
        ]);

        $user = $request->user();
        $address = $user->addresses()->where('id', $validated['address_id'])->firstOrFail();
        $cartItems = $user->carts()->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('user.cart')->with('error', 'Your cart is empty.');
        }

        $subtotal = $cartItems->sum(fn($item) => $item->price * $item->quantity);
        $isInsideValley = $this->isInsideKathmanduValley($address);
        $deliveryCharge = $this->calculateDeliveryCharge($subtotal, $isInsideValley);
        $tax = $subtotal * 0.13;

        $couponCode = $validated['coupon_code'] ?? session('applied_coupon.code');
        [$coupon, $couponDiscount] = $this->resolveCouponOrFail($user, $couponCode, $subtotal);

        $redeemPoints = (int) ($validated['redeem_points'] ?? 0);
        $pointsDiscount = 0;

        if ($redeemPoints > 0) {
            $maxPoints = RewardHelper::getMaxRedeemCoins($user, $subtotal);

            if ($redeemPoints > $maxPoints) {
                return back()->with('error', 'You can redeem a maximum of ' . number_format($maxPoints) . ' coins.');
            }

            if (!$user->hasEnoughCoins($redeemPoints)) {
                return back()->with('error', "You don't have enough coins. Available: " . number_format($user->reward_points));
            }

            $pointsDiscount = RewardHelper::calculateDiscount($redeemPoints);
        }

        $discount = round($couponDiscount + $pointsDiscount, 2);
        if ($discount > $subtotal) {
            $discount = $subtotal;
        }

        $grandTotal = round($subtotal - $discount + $deliveryCharge + $tax, 2);

        // ✅ Session save
        session()->put('checkout_confirmation', [
            'address_id' => $address->id,
            'payment_method' => $validated['payment_method'],
            'subtotal' => $subtotal,
            'coupon_id' => $coupon?->id,
            'coupon_code' => $coupon?->code,
            'coupon_discount' => $couponDiscount,
            'redeem_points' => $redeemPoints,
            'points_discount' => $pointsDiscount,
            'discount' => $discount,
            'delivery_charge' => $deliveryCharge,
            'tax' => $tax,
            'grand_total' => $grandTotal,
        ]);

        if (!empty($validated['initiate_khalti']) && $validated['payment_method'] === 'online') {
            return $this->initiateKhaltiPayment($user, $grandTotal);
        }

        return redirect()->route('checkout.confirm');
    }

    public function confirm(Request $request)
    {
        $checkout = session('checkout_confirmation');

        if (!$checkout) {
            return redirect()->route('checkout')->with('error', 'Please select your address and payment method first.');
        }

        $address = $request->user()->addresses()->find($checkout['address_id']);

        if (!$address) {
            session()->forget('checkout_confirmation');
            return redirect()->route('checkout')->with('error', 'Your selected delivery address is no longer available.');
        }

        $appliedCoupon = session('applied_coupon');
        $subtotal = $checkout['subtotal'];

        $couponCode = $appliedCoupon['code'] ?? $checkout['coupon_code'] ?? null;
        $couponDiscount = $appliedCoupon['discount'] ?? $checkout['coupon_discount'] ?? 0;

        $pointsDiscount = $checkout['points_discount'] ?? 0;
        $discount = round($couponDiscount + $pointsDiscount, 2);
        if ($discount > $subtotal) {
            $discount = $subtotal;
        }

        $grandTotal = round(
            $subtotal - $discount + $checkout['delivery_charge'] + ($checkout['tax'] ?? 0),
            2
        );

        return view('checkout.confirm', [
            'address'        => $address,
            'paymentMethod'  => $checkout['payment_method'],
            'subtotal'       => $subtotal,
            'couponCode'     => $couponCode,
            'couponDiscount' => $couponDiscount,
            'redeemPoints'   => $checkout['redeem_points'] ?? 0,
            'pointsDiscount' => $pointsDiscount,
            'discount'       => $discount,
            'deliveryCharge' => $checkout['delivery_charge'],
            'tax'            => $checkout['tax'] ?? 0,
            'grandTotal'     => $grandTotal,
        ]);
    }

    /**
     * ✅ Place Order - COD को लागि मात्र
     * (Online payment सधैं continueCheckout → Khalti बाट हुन्छ)
     */
    public function placeOrder(Request $request)
    {
        $validated = $request->validate([
            'address_id' => 'required|exists:addresses,id',
            'payment_method' => 'required|in:cod,online',
            'coupon_code' => 'nullable|string|max:50',
            'redeem_points' => 'nullable|integer|min:0',
        ]);

        
        if ($validated['payment_method'] === 'online') {
            return redirect()->route('khalti.initiate');
        }

        $user = $request->user();
        $checkout = session('checkout_confirmation', []);
        $redeemPoints = (int) ($validated['redeem_points'] ?? $checkout['redeem_points'] ?? 0);
        $couponCode = $validated['coupon_code'] ?? $checkout['coupon_code'] ?? session('applied_coupon.code');

        $address = $user->addresses()->where('id', $validated['address_id'])->firstOrFail();
        $cartItems = $user->carts()->with(['product', 'variant'])->lockForUpdate()->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('user.cart')->with('error', 'Your cart is empty.');
        }

        DB::beginTransaction();

        try {
            $subtotal = $this->validateStockAndCalculateSubtotal($cartItems);
            [$coupon, $couponDiscount] = $this->resolveCouponOrFail($user, $couponCode, $subtotal);
            $pointsDiscount = $this->validateAndRedeemCoins($user, $redeemPoints, $subtotal);

            $isInsideValley = $this->isInsideKathmanduValley($address);
            $deliveryCharge = $this->calculateDeliveryCharge($subtotal, $isInsideValley);
            $tax = $subtotal * 0.13;

            $discount = round($couponDiscount + $pointsDiscount, 2);
            if ($discount > $subtotal) {
                $discount = $subtotal;
            }
            $grandTotal = round($subtotal - $discount + $deliveryCharge + $tax, 2);

            $order = $this->createOrder($user, $address, $validated, [
                'subtotal' => $subtotal,
                'discount' => $discount,
                'deliveryCharge' => $deliveryCharge,
                'tax' => $tax,
                'grandTotal' => $grandTotal,
                'redeemPoints' => $redeemPoints,
                'paymentScreenshotPath' => null,
                'coupon' => $coupon,
                'transactionId' => null,
                'paymentStatus' => 'pending',
                'orderStatus' => 'pending',
            ]);

            $this->createPayment($order, $validated, $grandTotal, null);
            $this->createOrderItemsAndReduceStock($cartItems, $order);

            if ($coupon) {
                $coupon->incrementUsage();
            }

            if ($redeemPoints > 0) {
                $this->redeemUserCoins($user, $redeemPoints, $order, $pointsDiscount);
            }

            $user->carts()->delete();

            DB::commit();

            $this->sendOrderConfirmationEmail($order);

            session()->forget('checkout_confirmation');
            session()->forget('applied_coupon');

            return redirect()->route('user.order.view', $order->id)
                ->with('success', 'Your order has been placed successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Order placement error: ' . $e->getMessage());
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * ✅ Khalti payment पछि order place गर्ने
     */
    public function placeOrderAfterKhalti($user, array $khaltiData)
    {
        $checkout = session('checkout_confirmation');

        if (!$checkout) {
            throw new \Exception('Checkout session expired.');
        }

        $address = $user->addresses()->find($checkout['address_id']);

        if (!$address) {
            throw new \Exception('Delivery address not found.');
        }

        $cartItems = $user->carts()->with(['product', 'variant'])->lockForUpdate()->get();

        if ($cartItems->isEmpty()) {
            throw new \Exception('Your cart is empty.');
        }

        DB::beginTransaction();

        try {
            $subtotal = $this->validateStockAndCalculateSubtotal($cartItems);

            $coupon = null;
            $couponDiscount = 0;

            if (!empty($checkout['coupon_id'])) {
                $coupon = Coupon::find($checkout['coupon_id']);
                $couponDiscount = $checkout['coupon_discount'] ?? 0;
            }

            $redeemPoints = $checkout['redeem_points'] ?? 0;
            $pointsDiscount = $checkout['points_discount'] ?? 0;

            $isInsideValley = $this->isInsideKathmanduValley($address);
            $deliveryCharge = $this->calculateDeliveryCharge($subtotal, $isInsideValley);
            $tax = $subtotal * 0.13;

            $discount = round($couponDiscount + $pointsDiscount, 2);
            if ($discount > $subtotal) {
                $discount = $subtotal;
            }
            $grandTotal = round($subtotal - $discount + $deliveryCharge + $tax, 2);

            $order = $this->createOrder($user, $address, [
                'payment_method' => 'online',
                'transaction_id' => $khaltiData['transaction_id'] ?? null,
            ], [
                'subtotal' => $subtotal,
                'discount' => $discount,
                'deliveryCharge' => $deliveryCharge,
                'tax' => $tax,
                'grandTotal' => $grandTotal,
                'redeemPoints' => $redeemPoints,
                'paymentScreenshotPath' => null,
                'coupon' => $coupon,
                'transactionId' => $khaltiData['transaction_id'] ?? null,
                'paymentStatus' => 'paid',
                'orderStatus' => 'confirmed',
            ]);

            Payment::create([
                'order_id' => $order->id,
                'payment_method' => 'khalti',
                'transaction_id' => $khaltiData['transaction_id'] ?? null,
                'amount' => $grandTotal,
                'status' => 'completed',
                'gateway_response' => json_encode($khaltiData),
            ]);

            $this->createOrderItemsAndReduceStock($cartItems, $order);

            if ($coupon) {
                $coupon->incrementUsage();
            }

            if ($redeemPoints > 0) {
                $this->redeemUserCoins($user, $redeemPoints, $order, $pointsDiscount);
            }

            $user->carts()->delete();

            DB::commit();

            $this->sendOrderConfirmationEmail($order);

            session()->forget(['checkout_confirmation', 'applied_coupon', 'khalti_pidx', 'khalti_purchase_order_id']);

            return $order;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
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
            10000 => 0,
            5000 => 80,
            2000 => 100,
            1000 => 120,
            0 => 150,
        ] : [
            10000 => 100,
            5000 => 200,
            2000 => 300,
            1000 => 400,
            0 => 500,
        ];

        foreach ($tiers as $threshold => $charge) {
            if ($subtotal >= $threshold) return $charge;
        }

        return end($tiers);
    }

    private function validateStockAndCalculateSubtotal($cartItems): float
    {
        $subtotal = 0;

        foreach ($cartItems as $item) {
            if (!$item->product) {
                throw new \Exception('One of the products in your cart is no longer available.');
            }

            if ($item->variant_id) {
                if (!$item->variant) {
                    throw new \Exception('One of the selected product variants is no longer available.');
                }
                if ($item->variant->stock < $item->quantity) {
                    throw new \Exception($item->product->name . ' variant does not have enough stock.');
                }
            } else {
                if ($item->product->stock < $item->quantity) {
                    throw new \Exception($item->product->name . ' does not have enough stock. Available: ' . $item->product->stock);
                }
            }

            $subtotal += $item->price * $item->quantity;
        }

        return $subtotal;
    }

    private function validateAndRedeemCoins($user, int $redeemPoints, float $subtotal): float
    {
        if ($redeemPoints <= 0) return 0;

        $maxPoints = RewardHelper::getMaxRedeemCoins($user, $subtotal);

        if ($redeemPoints > $maxPoints) {
            throw new \Exception("You can redeem a maximum of " . number_format($maxPoints) . " coins.");
        }

        if (!$user->hasEnoughCoins($redeemPoints)) {
            throw new \Exception("You don't have enough coins. Available: " . number_format($user->reward_points));
        }

        return RewardHelper::calculateDiscount($redeemPoints);
    }

    private function createOrder($user, $address, $validated, array $data)
    {
        do {
            $orderNumber = 'TN-' . strtoupper(Str::random(10));
        } while (Order::where('order_number', $orderNumber)->exists());

        return Order::create([
            'user_id' => $user->id,
            'address_id' => $address->id,
            'coupon_id' => $data['coupon']?->id,
            'order_number' => $orderNumber,
            'subtotal' => $data['subtotal'],
            'discount' => $data['discount'],
            'delivery_charge' => $data['deliveryCharge'],
            'tax' => $data['tax'],
            'tax_percentage' => 13,
            'grand_total' => $data['grandTotal'],
            'payment_method' => $validated['payment_method'],
            'payment_status' => $data['paymentStatus'] ?? 'pending',
            'order_status' => $data['orderStatus'] ?? 'pending',
            'transaction_id' => $data['transactionId'] ?? ($validated['transaction_id'] ?? null),
            'payment_screenshot' => $data['paymentScreenshotPath'],
            'notes' => null,
            'current_location' => $data['orderStatus'] === 'confirmed' ? 'Payment received' : 'Order placed',
            'points_redeemed' => $data['redeemPoints'],
            'points_earned' => 0,
        ]);
    }

    private function createPayment($order, $validated, float $grandTotal, $transactionId): void
    {
        Payment::create([
            'order_id' => $order->id,
            'payment_method' => $validated['payment_method'] === 'online' ? 'khalti' : 'Cash on Delivery',
            'transaction_id' => $transactionId ?? ($validated['transaction_id'] ?? null),
            'amount' => $grandTotal,
            'status' => 'pending',
            'gateway_response' => null,
        ]);
    }

    private function createOrderItemsAndReduceStock($cartItems, $order): void
    {
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'variant_id' => $item->variant_id,
                'price' => $item->price,
                'quantity' => $item->quantity,
                'total' => round($item->price * $item->quantity, 2),
            ]);

            if ($item->variant_id) {
                $item->variant->decrement('stock', $item->quantity);
            } else {
                $product = Product::find($item->product_id);
                $product->decrement('stock', $item->quantity);
            }
        }
    }

    private function redeemUserCoins($user, int $redeemPoints, $order, float $pointsDiscount): void
    {
        $user->redeemCoins(
            $redeemPoints,
            $order->id,
            "Redeemed {$redeemPoints} coins for order #{$order->order_number} (Discount: Rs. " . number_format($pointsDiscount, 2) . ")"
        );
    }

    private function sendOrderConfirmationEmail($order): void
    {
        try {
            Mail::to($order->user->email)
                ->cc('technova2083@gmail.com')
                ->send(new OrderConfirmationMail($order));
        } catch (\Exception $e) {
            Log::error('Order confirmation email failed: ' . $e->getMessage());
        }
    }

    private function rememberCoupon($user, string $code, float $subtotal): void
    {
        try {
            [$coupon, $discount] = $this->resolveCouponOrFail($user, $code, $subtotal);

            if ($coupon) {
                session()->put('applied_coupon', [
                    'id' => $coupon->id,
                    'code' => $coupon->code,
                    'type' => $coupon->type,
                    'discount' => $discount,
                ]);
            }
        } catch (\Throwable $e) {
            session()->forget('applied_coupon');
            session()->flash('error', $e->getMessage());
        }
    }

    private function currentCoupon($user, float $subtotal): array
    {
        $applied = session('applied_coupon');

        if (!$applied) return [null, 0];

        try {
            [$coupon, $discount] = $this->resolveCouponOrFail($user, $applied['code'] ?? null, $subtotal);

            if ($coupon) {
                session()->put('applied_coupon.discount', $discount);
                return [$applied, $discount];
            }
        } catch (\Throwable $e) {
            session()->forget('applied_coupon');
        }

        return [null, 0];
    }

    /**
     * ✅ AJAX: Coupon apply गर्ने
     */
    public function applyCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:50',
        ]);

        $user = $request->user();
        $cartItems = $user->carts()->get();

        if ($cartItems->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Your cart is empty.',
            ], 400);
        }

        $subtotal = $cartItems->sum(fn($item) => $item->price * $item->quantity);

        try {
            [$coupon, $discount] = $this->resolveCouponOrFail($user, $request->code, $subtotal);

            session()->put('applied_coupon', [
                'id' => $coupon->id,
                'code' => $coupon->code,
                'type' => $coupon->type,
                'discount' => $discount,
            ]);

            return response()->json([
                'success' => true,
                'code' => $coupon->code,
                'discount' => $discount,
                'message' => 'Coupon applied successfully.',
            ]);
        } catch (\Throwable $e) {
            session()->forget('applied_coupon');

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * ✅ AJAX: Coupon remove गर्ने
     */
    public function removeCoupon(Request $request)
    {
        session()->forget('applied_coupon');

        return response()->json([
            'success' => true,
            'message' => 'Coupon removed.',
        ]);
    }

    private function resolveCouponOrFail($user, ?string $code, float $subtotal): array
    {
        if (!$code) return [null, 0];

        $coupon = Coupon::findByCode($code);

        if (!$coupon) {
            throw new \Exception('Invalid coupon code.');
        }

        $alreadyUsed = $user->orders()
            ->where('coupon_id', $coupon->id)
            ->where('order_status', '!=', 'cancelled')
            ->exists();

        if ($alreadyUsed) {
            throw new \Exception('You have already used this coupon.');
        }

        $result = $coupon->apply($subtotal);

        if (!$result['valid']) {
            throw new \Exception($result['message']);
        }

        return [$coupon, round($result['discount'], 2)];
    }

    /**
     * ✅ Khalti payment initiate - direct API call
     */
    private function initiateKhaltiPayment($user, float $grandTotal)
    {
        if ($grandTotal < 10) {
            return redirect()->route('checkout')
                ->with('error', 'Amount must be at least Rs. 10 for Khalti payment.');
        }

        $purchaseOrderId = 'TN-' . strtoupper(Str::random(10));
        session()->put('khalti_purchase_order_id', $purchaseOrderId);

        $payload = [
            'return_url' => route('khalti.callback'),
            'website_url' => config('app.url'),
            'amount' => (int) round($grandTotal * 100),
            'purchase_order_id' => $purchaseOrderId,
            'purchase_order_name' => 'Order ' . $purchaseOrderId,
            'customer_info' => [
                'name' => $user->name ?? 'Customer',
                'email' => $user->email ?? 'customer@example.com',
                'phone' => $user->phone ?? '9800000000',
            ],
        ];

        try {
            $response = \Illuminate\Support\Facades\Http::withHeaders([
                'Authorization' => 'Key ' . config('services.khalti.secret_key'),
                'Content-Type' => 'application/json',
            ])->post(config('services.khalti.base_url') . '/epayment/initiate/', $payload);

            if (!$response->successful()) {
                \Illuminate\Support\Facades\Log::error('Khalti initiate failed', ['body' => $response->body()]);
                return redirect()->route('checkout')
                    ->with('error', 'Payment initialization failed. Please try again.');
            }

            $data = $response->json();
            session()->put('khalti_pidx', $data['pidx']);

            return redirect($data['payment_url']);

        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Khalti initiate exception: ' . $e->getMessage());
            return redirect()->route('checkout')
                ->with('error', 'Payment gateway error. Please try again.');
        }
    }
}