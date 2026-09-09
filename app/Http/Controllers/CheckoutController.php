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

        $cartItems = $user->carts()->with(['product', 'variant'])->latest()->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('user.cart')->with('error', 'Your cart is empty.');
        }

        $subtotal = $cartItems->sum(fn($item) => $item->price * $item->quantity);
        $deliveryCharge = 100;
        $tax = $subtotal * 0.13;
        $addresses = $user->addresses()->latest()->get();

        $coinSummary = RewardHelper::getUserCoinsSummary($user);
        $maxRedeemPoints = RewardHelper::getMaxRedeemCoins($user, $subtotal);
        $maxPointsDiscount = RewardHelper::calculateDiscount($maxRedeemPoints);

        return view('checkout.index', compact(
            'cartItems',
            'subtotal',
            'deliveryCharge',
            'tax',
            'addresses',
            'coinSummary',
            'maxRedeemPoints',
            'maxPointsDiscount'
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

    public function continueCheckout(Request $request)
    {
        $validated = $request->validate([
            'address_id' => 'required|exists:addresses,id',
            'payment_method' => 'required|in:cod,online',
            'redeem_points' => 'nullable|integer|min:0',
        ]);

        $user = $request->user();
        $address = $user->addresses()->where('id', $validated['address_id'])->firstOrFail();
        $cartItems = $user->carts()->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('user.cart')->with('error', 'Your cart is empty.');
        }

        $subtotal = $cartItems->sum(fn($item) => $item->price * $item->quantity);
        $deliveryCharge = 100;
        $tax = $subtotal * 0.13;

        // Coin redemption
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

        $discount = round($pointsDiscount, 2);
        $grandTotal = round($subtotal - $discount + $deliveryCharge + $tax, 2);

        session()->put('checkout_confirmation', [
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
        $checkout = session('checkout_confirmation');

        if (!$checkout) {
            return redirect()->route('checkout')->with('error', 'Please select your address and payment method first.');
        }

        $address = $request->user()->addresses()->find($checkout['address_id']);

        if (!$address) {
            session()->forget('checkout_confirmation');
            return redirect()->route('checkout')->with('error', 'Your selected delivery address is no longer available.');
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
            'transaction_id' => ['nullable', 'string', 'max:100', 'required_if:payment_method,online'],
            'payment_screenshot' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120', 'required_if:payment_method,online'],
        ]);

        $user = $request->user();
        $checkout = session('checkout_confirmation', []);
        $redeemPoints = (int) ($checkout['redeem_points'] ?? 0);

        $paymentScreenshotPath = null;
        if ($validated['payment_method'] === 'online' && $request->hasFile('payment_screenshot')) {
            $paymentScreenshotPath = $request->file('payment_screenshot')->store('payment-screenshots', 'public');
        }

        $address = $user->addresses()->where('id', $validated['address_id'])->firstOrFail();
        $cartItems = $user->carts()->with(['product', 'variant'])->lockForUpdate()->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('user.cart')->with('error', 'Your cart is empty.');
        }

        DB::beginTransaction();

        try {
            $subtotal = 0;

            // Validate stock and calculate subtotal
            foreach ($cartItems as $item) {
                if (!$item->product) {
                    throw new \Exception('One of the products in your cart is no longer available.');
                }

                if ($item->variant_id) {
                    if (!$item->variant) {
                        throw new \Exception('One of the selected product variants is no longer available.');
                    }
                    if ($item->variant->stock < $item->quantity) {
                        throw new \Exception($item->product->name . ' does not have enough stock.');
                    }
                } else {
                    if ($item->product->stock < $item->quantity) {
                        throw new \Exception($item->product->name . ' does not have enough stock.');
                    }
                }

                $subtotal += $item->price * $item->quantity;
            }

            // Coin redemption (re-validated)
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

            $deliveryCharge = 100;
            $tax = $subtotal * 0.13;
            $discount = round($pointsDiscount, 2);
            $grandTotal = round($subtotal - $discount + $deliveryCharge + $tax, 2);

            // Generate order number
            do {
                $orderNumber = 'TN-' . strtoupper(Str::random(10));
            } while (Order::where('order_number', $orderNumber)->exists());

            // Create order
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

            // Create payment record
            Payment::create([
                'order_id' => $order->id,
                'payment_method' => $validated['payment_method'] === 'online' ? 'esewa' : 'Cash on Delivery',
                'transaction_id' => $validated['transaction_id'] ?? null,
                'amount' => $grandTotal,
                'status' => 'pending',
                'gateway_response' => null,
            ]);

            // Create order items and reduce stock
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
                    $item->product->decrement('stock', $item->quantity);
                }
            }

            // Redeem coins
            if ($redeemPoints > 0) {
                $user->redeemCoins(
                    $redeemPoints,
                    $order->id,
                    "Redeemed {$redeemPoints} coins for order #{$order->order_number} (Discount: Rs. " . number_format($pointsDiscount, 2) . ")"
                );
            }

            // Clear cart
            $user->carts()->delete();

            DB::commit();

            // Send email
            try {
                Mail::to($order->user->email)
                    ->cc('technova2083@gmail.com')
                    ->send(new OrderConfirmationMail($order));
            } catch (\Exception $e) {
                Log::error('Order confirmation email failed: ' . $e->getMessage());
            }

            session()->forget('checkout_confirmation');

            return redirect()->route('user.order.view', $order->id)
                ->with('success', 'Your order has been placed successfully.');

        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->with('error', $e->getMessage());
        }
    }
}
