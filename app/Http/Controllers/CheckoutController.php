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

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $cartItems = $user->carts()
            ->with(['product', 'variant'])
            ->latest()
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()
                ->route('user.cart')
                ->with('error', 'Your cart is empty.');
        }

        $subtotal = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        $deliveryCharge = 100;
        $tax = $subtotal * 0.13; // 13% VAT

        $addresses = $user->addresses()
            ->latest()
            ->get();

        // 🪙 Coin / reward data for the checkout page
        $coinSummary = RewardHelper::getUserCoinsSummary($user);
        $maxRedeemPoints = RewardHelper::getMaxRedeemCoins($user, $subtotal);
        $maxPointsDiscount = RewardHelper::calculateDiscount($maxRedeemPoints);

        return view('checkout.index', [
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'deliveryCharge' => $deliveryCharge,
            'tax' => $tax,
            'addresses' => $addresses,
            'coinSummary' => $coinSummary,
            'maxRedeemPoints' => $maxRedeemPoints,
            'maxPointsDiscount' => $maxPointsDiscount,
        ]);
    }

    public function createAddress()
    {
        return view('checkout.address');
    }

    /**
     * Store a new address (Supports AJAX)
     */
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

        if (!$user->addresses()->exists()) {
            $validated['is_default'] = true;
        } else {
            $validated['is_default'] = false;
        }

        $address = Address::create($validated);

        // ✅ Return JSON for AJAX request
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Address saved successfully.',
                'address' => $address
            ]);
        }

        return redirect()
            ->route('checkout')
            ->with('success', 'Address added successfully.');
    }

    public function continueCheckout(Request $request)
    {
        $validated = $request->validate([
            'address_id' => 'required|exists:addresses,id',
            'payment_method' => 'required|in:cod,online',
            'redeem_points' => 'nullable|integer|min:0',
        ]);

        $user = $request->user();

        $address = $user->addresses()
            ->where('id', $validated['address_id'])
            ->firstOrFail();

        $cartItems = $user->carts()
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()
                ->route('user.cart')
                ->with('error', 'Your cart is empty.');
        }

        // Calculate subtotal
        $subtotal = 0;
        foreach ($cartItems as $cartItem) {
            $subtotal += $cartItem->price * $cartItem->quantity;
        }

        // ❌ Online payment discount REMOVED (5% discount hataiyo)

        // 🪙 Coin redemption discount
        $redeemPoints = (int) ($validated['redeem_points'] ?? 0);
        $pointsDiscount = 0;

        if ($redeemPoints > 0) {
            $maxPoints = RewardHelper::getMaxRedeemCoins($user, $subtotal);

            if ($redeemPoints > $maxPoints) {
                return back()->with('error', "You can redeem a maximum of " . number_format($maxPoints) . " coins.");
            }

            if (!$user->hasEnoughCoins($redeemPoints)) {
                return back()->with('error', "You don't have enough coins. Available: " . number_format($user->reward_points));
            }

            $pointsDiscount = RewardHelper::calculateDiscount($redeemPoints);
        }

        // Flat delivery charge
        $deliveryCharge = 100;

        // Tax (13% VAT)
        $tax = $subtotal * 0.13;

        // Final amount
        $discount = round($pointsDiscount, 2);
        $grandTotal = round($subtotal - $discount + $deliveryCharge + $tax, 2);

        $request->session()->put('checkout_confirmation', [
            'address_id' => $address->id,
            'payment_method' => $validated['payment_method'],
            'subtotal' => $subtotal,
            'redeem_points' => $redeemPoints,
            'points_discount' => $pointsDiscount,
            'discount' => $discount,
            'delivery_charge' => $deliveryCharge,
            'tax' => $tax,
            'grand_total' => $grandTotal,
        ]);

        return redirect()->route('checkout.confirm');
    }

    public function confirm(Request $request)
    {
        $checkout = $request->session()->get('checkout_confirmation');

        if (!$checkout) {
            return redirect()
                ->route('checkout')
                ->with('error', 'Please select your address and payment method first.');
        }

        $address = $request->user()
            ->addresses()
            ->find($checkout['address_id']);

        if (!$address) {
            $request->session()->forget('checkout_confirmation');
            return redirect()
                ->route('checkout')
                ->with('error', 'Your selected delivery address is no longer available.');
        }

        return view('checkout.confirm', [
            'address' => $address,
            'paymentMethod' => $checkout['payment_method'],
            'subtotal' => $checkout['subtotal'],
            'redeemPoints' => $checkout['redeem_points'] ?? 0,
            'pointsDiscount' => $checkout['points_discount'] ?? 0,
            'discount' => $checkout['discount'],
            'deliveryCharge' => $checkout['delivery_charge'],
            'tax' => $checkout['tax'] ?? 0,
            'grandTotal' => $checkout['grand_total'],
        ]);
    }

    public function placeOrder(Request $request)
    {
        $validated = $request->validate([
            'address_id' => 'required|exists:addresses,id',
            'payment_method' => 'required|in:cod,online',
            'transaction_id' => [
                'nullable',
                'string',
                'max:100',
                \Illuminate\Validation\Rule::requiredIf(
                    $request->input('payment_method') === 'online'
                ),
            ],
            'payment_screenshot' => [
                'nullable',
                'image',
                'mimes:jpeg,jpg,png,webp',
                'max:5120',
                \Illuminate\Validation\Rule::requiredIf(
                    $request->input('payment_method') === 'online'
                ),
            ],
        ]);

        $user = $request->user();

        $checkoutSession = $request->session()->get('checkout_confirmation', []);
        $redeemPoints = (int) ($checkoutSession['redeem_points'] ?? 0);

        $paymentScreenshotPath = null;

        if ($validated['payment_method'] === 'online' && $request->hasFile('payment_screenshot')) {
            $paymentScreenshotPath = $request
                ->file('payment_screenshot')
                ->store('payment-screenshots', 'public');
        }

        // Make sure the selected address belongs to this user.
        $address = $user->addresses()
            ->where('id', $validated['address_id'])
            ->firstOrFail();

        // Get only this user's cart.
        $cartItems = $user->carts()
            ->with(['product', 'variant'])
            ->lockForUpdate()
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()
                ->route('user.cart')
                ->with('error', 'Your cart is empty.');
        }

        DB::beginTransaction();

        try {
            $subtotal = 0;

            // Validate products, variants and stock
            foreach ($cartItems as $cartItem) {
                if (!$cartItem->product) {
                    throw new \Exception('One of the products in your cart is no longer available.');
                }

                // Variant product
                if ($cartItem->variant_id) {
                    if (!$cartItem->variant) {
                        throw new \Exception('One of the selected product variants is no longer available.');
                    }
                    if ($cartItem->variant->stock < $cartItem->quantity) {
                        throw new \Exception($cartItem->product->name . ' does not have enough stock.');
                    }
                } else {
                    // Normal product
                    if ($cartItem->product->stock < $cartItem->quantity) {
                        throw new \Exception($cartItem->product->name . ' does not have enough stock.');
                    }
                }

                // Recalculate subtotal from the server-side cart
                $itemTotal = $cartItem->price * $cartItem->quantity;
                $subtotal += $itemTotal;
            }

            // ❌ Online payment discount REMOVED

            // 🪙 Coin redemption discount
            $pointsDiscount = 0;

            if ($redeemPoints > 0) {
                $maxPoints = RewardHelper::getMaxRedeemCoins($user, $subtotal);

                if ($redeemPoints > $maxPoints) {
                    throw new \Exception("You can redeem a maximum of " . number_format($maxPoints) . " coins.");
                }

                if (!$user->hasEnoughCoins($redeemPoints)) {
                    throw new \Exception("You don't have enough coins. Available: " . number_format($user->reward_points));
                }

                $pointsDiscount = RewardHelper::calculateDiscount($redeemPoints);
            }

            // Flat delivery charge
            $deliveryCharge = 100;

            // Tax (13% VAT)
            $tax = $subtotal * 0.13;

            // Total discount and final total
            $discount = round($pointsDiscount, 2);
            $grandTotal = round($subtotal - $discount + $deliveryCharge + $tax, 2);

            // Generate unique order number
            do {
                $orderNumber = 'TN-' . strtoupper(Str::random(10));
            } while (Order::where('order_number', $orderNumber)->exists());

            // Create Order
            $order = Order::create([
                'user_id' => $user->id,
                'address_id' => $address->id,
                'coupon_id' => null,
                'order_number' => $orderNumber,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'delivery_charge' => $deliveryCharge,
                'tax' => $tax,
                'tax_percentage' => 13,
                'grand_total' => $grandTotal,
                'payment_method' => $validated['payment_method'],
                'payment_status' => 'pending',
                'order_status' => 'pending',
                'transaction_id' => $validated['transaction_id'] ?? null,
                'payment_screenshot' => $paymentScreenshotPath,
                'notes' => null,
                'current_location' => 'Order placed',
                'points_redeemed' => $redeemPoints,
                'points_earned' => 0,
            ]);

            Payment::create([
                'order_id' => $order->id,
                'payment_method' => $validated['payment_method'] === 'online' ? 'esewa' : 'Cash on Delivery',
                'transaction_id' => $validated['transaction_id'] ?? null,
                'amount' => $grandTotal,
                'status' => 'pending',
                'gateway_response' => null,
            ]);

            // Create Order Items and reduce stock
            foreach ($cartItems as $cartItem) {
                $itemTotal = round($cartItem->price * $cartItem->quantity, 2);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'variant_id' => $cartItem->variant_id,
                    'price' => $cartItem->price,
                    'quantity' => $cartItem->quantity,
                    'total' => $itemTotal,
                ]);

                // Reduce stock
                if ($cartItem->variant_id) {
                    $cartItem->variant->decrement('stock', $cartItem->quantity);
                } else {
                    $cartItem->product->decrement('stock', $cartItem->quantity);
                }
            }

            // 🪙 Redeem coins
            if ($redeemPoints > 0) {
                $user->redeemCoins(
                    $redeemPoints,
                    $order->id,
                    "Redeemed " . $redeemPoints . " coins for order #{$order->order_number} (Discount: Rs. " . number_format($pointsDiscount, 2) . ")"
                );
            }

            // Clear cart
            $user->carts()->delete();

            DB::commit();

            // Send order confirmation email
            try {
                Mail::to($order->user->email)
                    ->cc('technova2083@gmail.com')
                    ->send(new OrderConfirmationMail($order));
            } catch (\Exception $e) {
                Log::error('Order confirmation email failed: ' . $e->getMessage());
            }

            $request->session()->forget('checkout_confirmation');

            return redirect()
                ->route('user.order.view', $order->id)
                ->with('success', 'Your order has been placed successfully.');

        } catch (\Throwable $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }
}
