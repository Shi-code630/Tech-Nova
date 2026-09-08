<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

use App\Mail\OrderConfirmationMail;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;

class CheckoutController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CHECKOUT PAGE
    |--------------------------------------------------------------------------
    */

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

        $addresses = $user->addresses()
            ->latest()
            ->get();

        return view('checkout.index', [
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'deliveryCharge' => $deliveryCharge,
            'addresses' => $addresses,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | MY ADDRESSES PAGE
    |--------------------------------------------------------------------------
    */

    public function addresses(Request $request)
    {
        $user = $request->user();

        $addresses = $user->addresses()
            ->latest()
            ->get();

        return view('user.addresses.index', compact('addresses'));
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE ADDRESS
    |--------------------------------------------------------------------------
    */

    public function createAddress()
    {
        return view('checkout.address');
    }


    /*
    |--------------------------------------------------------------------------
    | STORE ADDRESS
    |--------------------------------------------------------------------------
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

        // Address ko logged-in user ke saath connect karega
        $validated['user_id'] = $user->id;

        // First address automatically default hoga
        if (!$user->addresses()->exists()) {
            $validated['is_default'] = true;
        } else {
            $validated['is_default'] = false;
        }

        Address::create($validated);

        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        |
        | Agar form se "from=addresses" aaya hai to My Addresses par wapas jayega.
        | Otherwise normal checkout par jayega.
        |
        */

        if ($request->input('from') === 'addresses') {
            return redirect()
                ->route('checkout.addresses')
                ->with('success', 'Address added successfully.');
        }

        return redirect()
            ->route('checkout')
            ->with('success', 'Address added successfully.');
    }


    /*
    |--------------------------------------------------------------------------
    | EDIT ADDRESS
    |--------------------------------------------------------------------------
    */

    public function editAddress(Request $request, $id)
    {
        $address = $request->user()
            ->addresses()
            ->where('id', $id)
            ->firstOrFail();

        return view('checkout.address-edit', compact('address'));
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE ADDRESS
    |--------------------------------------------------------------------------
    */

    public function updateAddress(Request $request, $id)
    {
        $address = $request->user()
            ->addresses()
            ->where('id', $id)
            ->firstOrFail();

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

        return redirect()
            ->route('checkout.addresses')
            ->with('success', 'Address updated successfully.');
    }


    /*
    |--------------------------------------------------------------------------
    | DELETE ADDRESS
    |--------------------------------------------------------------------------
    */

    public function deleteAddress(Request $request, $id)
    {
        $address = $request->user()
            ->addresses()
            ->where('id', $id)
            ->firstOrFail();

        // Check karenge ki delete hone wala address default tha ya nahi
        $wasDefault = $address->is_default;

        $address->delete();

        /*
        |--------------------------------------------------------------------------
        | Agar default address delete hua hai
        |--------------------------------------------------------------------------
        |
        | To latest remaining address ko default bana denge.
        |
        */

        if ($wasDefault) {
            $newDefault = $request->user()
                ->addresses()
                ->latest()
                ->first();

            if ($newDefault) {
                $newDefault->update([
                    'is_default' => true,
                ]);
            }
        }

        return redirect()
            ->route('checkout.addresses')
            ->with('success', 'Address deleted successfully.');
    }


    /*
    |--------------------------------------------------------------------------
    | CONTINUE CHECKOUT
    |--------------------------------------------------------------------------
    */

    public function continueCheckout(Request $request)
    {
        $validated = $request->validate([
            'address_id' => 'required|exists:addresses,id',
            'payment_method' => 'required|in:cod,online',
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

        /*
        |--------------------------------------------------------------------------
        | Calculate subtotal
        |--------------------------------------------------------------------------
        */

        $subtotal = 0;

        foreach ($cartItems as $cartItem) {
            $subtotal += $cartItem->price * $cartItem->quantity;
        }


        /*
        |--------------------------------------------------------------------------
        | 5% online payment discount
        |--------------------------------------------------------------------------
        */

        $discount = 0;

        if ($validated['payment_method'] === 'online') {
            $discount = round($subtotal * 0.05, 2);
        }


        /*
        |--------------------------------------------------------------------------
        | Delivery charge
        |--------------------------------------------------------------------------
        */

        $deliveryCharge = 100;


        /*
        |--------------------------------------------------------------------------
        | Final amount
        |--------------------------------------------------------------------------
        */

        $grandTotal = round(
            $subtotal - $discount + $deliveryCharge,
            2
        );


        $request->session()->put('checkout_confirmation', [
            'address_id' => $address->id,
            'payment_method' => $validated['payment_method'],
            'subtotal' => $subtotal,
            'discount' => $discount,
            'delivery_charge' => $deliveryCharge,
            'grand_total' => $grandTotal,
        ]);

        return redirect()->route('checkout.confirm');
    }


    /*
    |--------------------------------------------------------------------------
    | CONFIRM CHECKOUT
    |--------------------------------------------------------------------------
    */

    public function confirm(Request $request)
    {
        $checkout = $request->session()->get('checkout_confirmation');

        if (!$checkout) {
            return redirect()
                ->route('checkout')
                ->with(
                    'error',
                    'Please select your address and payment method first.'
                );
        }

        $address = $request->user()
            ->addresses()
            ->find($checkout['address_id']);

        if (!$address) {
            $request->session()->forget('checkout_confirmation');

            return redirect()
                ->route('checkout')
                ->with(
                    'error',
                    'Your selected delivery address is no longer available.'
                );
        }

        return view('checkout.confirm', [
            'address' => $address,
            'paymentMethod' => $checkout['payment_method'],
            'subtotal' => $checkout['subtotal'],
            'discount' => $checkout['discount'],
            'deliveryCharge' => $checkout['delivery_charge'],
            'grandTotal' => $checkout['grand_total'],
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | PLACE ORDER
    |--------------------------------------------------------------------------
    */

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

        $paymentScreenshotPath = null;


        /*
        |--------------------------------------------------------------------------
        | Payment Screenshot
        |--------------------------------------------------------------------------
        */

        if (
            $validated['payment_method'] === 'online'
            && $request->hasFile('payment_screenshot')
        ) {
            $paymentScreenshotPath = $request
                ->file('payment_screenshot')
                ->store('payment-screenshots', 'public');
        }


        /*
        |--------------------------------------------------------------------------
        | Make sure address belongs to this user
        |--------------------------------------------------------------------------
        */

        $address = $user->addresses()
            ->where('id', $validated['address_id'])
            ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | Get user's cart
        |--------------------------------------------------------------------------
        */

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


            /*
            |--------------------------------------------------------------------------
            | Validate products, variants and stock
            |--------------------------------------------------------------------------
            */

            foreach ($cartItems as $cartItem) {

                if (!$cartItem->product) {
                    throw new \Exception(
                        'One of the products in your cart is no longer available.'
                    );
                }


                /*
                |--------------------------------------------------------------------------
                | Variant product
                |--------------------------------------------------------------------------
                */

                if ($cartItem->variant_id) {

                    if (!$cartItem->variant) {
                        throw new \Exception(
                            'One of the selected product variants is no longer available.'
                        );
                    }

                    if ($cartItem->variant->stock < $cartItem->quantity) {
                        throw new \Exception(
                            $cartItem->product->name .
                            ' does not have enough stock.'
                        );
                    }

                } else {

                    /*
                    |--------------------------------------------------------------------------
                    | Normal product
                    |--------------------------------------------------------------------------
                    */

                    if ($cartItem->product->stock < $cartItem->quantity) {
                        throw new \Exception(
                            $cartItem->product->name .
                            ' does not have enough stock.'
                        );
                    }
                }


                /*
                |--------------------------------------------------------------------------
                | Recalculate subtotal
                |--------------------------------------------------------------------------
                */

                $itemTotal =
                    $cartItem->price *
                    $cartItem->quantity;

                $subtotal += $itemTotal;
            }


            /*
            |--------------------------------------------------------------------------
            | Online payment discount
            |--------------------------------------------------------------------------
            */

            $discount = 0;

            if ($validated['payment_method'] === 'online') {
                $discount = round($subtotal * 0.05, 2);
            }


            /*
            |--------------------------------------------------------------------------
            | Delivery charge
            |--------------------------------------------------------------------------
            */

            $deliveryCharge = 100;


            /*
            |--------------------------------------------------------------------------
            | Tax
            |--------------------------------------------------------------------------
            */

            $tax = 0;


            /*
            |--------------------------------------------------------------------------
            | Final total
            |--------------------------------------------------------------------------
            */

            $grandTotal = round(
                $subtotal
                - $discount
                + $deliveryCharge
                + $tax,
                2
            );


            /*
            |--------------------------------------------------------------------------
            | Generate unique order number
            |--------------------------------------------------------------------------
            */

            do {

                $orderNumber =
                    'TN-' .
                    strtoupper(Str::random(10));

            } while (
                Order::where(
                    'order_number',
                    $orderNumber
                )->exists()
            );


            /*
            |--------------------------------------------------------------------------
            | Create Order
            |--------------------------------------------------------------------------
            */

            $order = Order::create([

                'user_id' => $user->id,

                'address_id' => $address->id,

                'coupon_id' => null,

                'order_number' => $orderNumber,

                'subtotal' => $subtotal,

                'discount' => $discount,

                'delivery_charge' => $deliveryCharge,

                'tax' => $tax,

                'grand_total' => $grandTotal,

                'payment_method' =>
                    $validated['payment_method'],

                'payment_status' => 'pending',

                'order_status' => 'pending',

                'transaction_id' =>
                    $validated['transaction_id'] ?? null,

                'payment_screenshot' =>
                    $paymentScreenshotPath,

                'notes' => null,
            ]);


            /*
            |--------------------------------------------------------------------------
            | Create Payment
            |--------------------------------------------------------------------------
            */

            Payment::create([

                'order_id' => $order->id,

                'payment_method' =>
                    $validated['payment_method'] === 'online'
                        ? 'esewa'
                        : 'Cash on Delivery',

                'transaction_id' =>
                    $validated['transaction_id'] ?? null,

                'amount' => $grandTotal,

                'status' => 'pending',

                'gateway_response' => null,
            ]);


            /*
            |--------------------------------------------------------------------------
            | Create Order Items and reduce stock
            |--------------------------------------------------------------------------
            */

            foreach ($cartItems as $cartItem) {

                $itemTotal = round(
                    $cartItem->price *
                    $cartItem->quantity,
                    2
                );


                OrderItem::create([

                    'order_id' => $order->id,

                    'product_id' =>
                        $cartItem->product_id,

                    'variant_id' =>
                        $cartItem->variant_id,

                    'price' =>
                        $cartItem->price,

                    'quantity' =>
                        $cartItem->quantity,

                    'total' =>
                        $itemTotal,
                ]);


                /*
                |--------------------------------------------------------------------------
                | Reduce stock
                |--------------------------------------------------------------------------
                */

                if ($cartItem->variant_id) {

                    $cartItem->variant->decrement(
                        'stock',
                        $cartItem->quantity
                    );

                } else {

                    $cartItem->product->decrement(
                        'stock',
                        $cartItem->quantity
                    );
                }
            }


            /*
            |--------------------------------------------------------------------------
            | Clear user's cart
            |--------------------------------------------------------------------------
            */

            $user->carts()->delete();


            DB::commit();


            /*
            |--------------------------------------------------------------------------
            | Send order confirmation email
            |--------------------------------------------------------------------------
            */

            try {

                Mail::to($order->user->email)
                    ->cc('technova2083@gmail.com')
                    ->send(
                        new OrderConfirmationMail($order)
                    );

            } catch (\Exception $e) {

                Log::error(
                    'Order confirmation email failed: ' .
                    $e->getMessage()
                );
            }


            $request->session()
                ->forget('checkout_confirmation');


            return redirect()
                ->route(
                    'user.order.view',
                    $order->id
                )
                ->with(
                    'success',
                    'Your order has been placed successfully.'
                );


        } catch (\Throwable $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with(
                    'error',
                    $e->getMessage()
                );
        }
    }
}
