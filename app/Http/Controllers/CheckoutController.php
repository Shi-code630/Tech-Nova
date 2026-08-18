<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;

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

        $addresses = $user->addresses()
            ->latest()
            ->get();

        return view('checkout.index', [
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'addresses' => $addresses,
        ]);
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

        // If this is the user's first address,
        // automatically make it the default address.
        if (!$user->addresses()->exists()) {
            $validated['is_default'] = true;
        } else {
            $validated['is_default'] = false;
        }

        Address::create($validated);

        return redirect()
            ->route('checkout')
            ->with('success', 'Address added successfully.');
    }

        public function continueCheckout(Request $request)
    {
        $validated = $request->validate([
            'address_id' => 'required|exists:addresses,id',
            'payment_method' => 'required|in:cod,online',
        ]);

        $address = $request->user()
            ->addresses()
            ->where('id', $validated['address_id'])
            ->firstOrFail();

        return view('checkout.confirm', [
            'address' => $address,
            'paymentMethod' => $validated['payment_method'],
        ]);
    }


}
