<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display the user's cart.
     */
    public function index(Request $request)
    {
        $cartItems = $request->user()
            ->carts()
            ->with('product')
            ->latest()
            ->get();

        $subtotal = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        return view('user.cart.index', compact(
            'cartItems',
            'subtotal'
        ));
    }


    /**
     * Add product to cart.
     */
    public function addToCart(Request $request, $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $user = $request->user();

        $product = Product::findOrFail($product);

        if ($product->stock < $request->quantity) {
            return back()->with(
                'error',
                'Not enough stock available.'
            );
        }

        $quantity = (int) $request->quantity;

        $cart = Cart::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->whereNull('variant_id')
            ->first();

        if ($cart) {

            $newQuantity = $cart->quantity + $quantity;

            if ($newQuantity > $product->stock) {
                return back()->with(
                    'error',
                    'You cannot add more than the available stock.'
                );
            }

            $cart->update([
                'quantity' => $newQuantity,
                'price' => $product->discount_price ?? $product->price,
            ]);

        } else {

            Cart::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'variant_id' => null,
                'quantity' => $quantity,
                'price' => $product->discount_price ?? $product->price,
            ]);
        }

        return redirect()
            ->route('user.cart')
            ->with(
                'success',
                'Product added to cart successfully.'
            );
    }

    public function removeFromCart(Request $request, $cart)
    {
            $cartItem = Cart::where('id', $cart)
                ->where('user_id', $request->user()->id)
                ->firstOrFail();

            $cartItem->delete();

            return redirect()
                ->route('user.cart')
                ->with('success', 'Product removed from cart.');
    }

         public function updateQuantity(Request $request, $cart)
        {
            $request->validate([
                'quantity' => 'required|integer|min:1',
            ]);

            $cartItem = Cart::where('id', $cart)
                ->where('user_id', $request->user()->id)
                ->with('product')
                ->firstOrFail();

            $quantity = (int) $request->quantity;

            // Check available stock
            if ($quantity > $cartItem->product->stock) {
                return back()->with(
                    'error',
                    'You cannot add more than the available stock.'
                );
            }

            $cartItem->update([
                'quantity' => $quantity,
            ]);

            return redirect()
                ->route('user.cart')
                ->with('success', 'Cart quantity updated.');
        }
}
