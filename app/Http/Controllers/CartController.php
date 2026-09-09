<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;


class CartController extends Controller
{
    /**
     * Tax rate for Nepal (VAT)
     */
    private const TAX_RATE = 13;

    /**
     * Valley districts and cities for delivery calculation
     */
    private const VALLEY_DISTRICTS = ['kathmandu', 'lalitpur', 'bhaktapur'];
    private const VALLEY_CITIES = [
        'kathmandu', 'lalitpur', 'bhaktapur',
        'patan', 'kirtipur', 'madhyapur thimi',
        'thimi', 'madhyapur'
    ];

    /**
     * Display the user's cart with pricing calculations.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $cartItems = $user
            ->carts()
            ->with(['product', 'variant'])
            ->latest()
            ->get();

        // Calculate subtotal
        $subtotal = $this->calculateSubtotal($cartItems);

        // Check default address location
        $isInsideValley = $this->isInsideKathmanduValley($user);

        // Calculate delivery based on location + subtotal
        $deliveryCharge = $this->calculateDeliveryCharge(
            $subtotal,
            $isInsideValley
        );

        // Calculate VAT
        $taxRate = self::TAX_RATE;
        $taxAmount = $this->calculateTax($subtotal, $taxRate);

        // Final total
        $total = $subtotal + $deliveryCharge + $taxAmount;

        return view('user.cart.index', compact(
            'cartItems',
            'subtotal',
            'taxAmount',
            'deliveryCharge',
            'total',
            'isInsideValley',
            'taxRate' // Added this missing variable
        ));
    }

    /**
     * Add product to cart.
     */
    public function addToCart(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:10',
            'variant_id' => 'nullable|exists:variants,id'
        ]);

        $user = $request->user();
        $product = Product::findOrFail($productId);
        $quantity = (int) $request->quantity;

        // Check if product is active
        if (!$product->is_active) {
            return $this->redirectBackWithError(
                'This product is currently not available.'
            );
        }

        // Check stock
        if ($product->stock < $quantity) {
            return $this->redirectBackWithError(
                'Not enough stock available. Only ' . $product->stock . ' items left.'
            );
        }

        $variantId = $request->variant_id;
        $cart = $this->getCartItem(
            $user->id,
            $product->id,
            $variantId
        );

        if ($cart) {
            $newQuantity = $cart->quantity + $quantity;

            // Check stock again
            if ($newQuantity > $product->stock) {
                return $this->redirectBackWithError(
                    'You cannot add more than the available stock.'
                );
            }

            $cart->update([
                'quantity' => $newQuantity,
                'price' => $this->getProductPrice($product),
            ]);

        } else {
            $this->createCartItem(
                $user->id,
                $product->id,
                $variantId,
                $quantity,
                $product
            );
        }

        return redirect()
            ->route('user.cart')
            ->with('success', 'Product added to cart successfully.');
    }

    /**
     * Remove product from cart.
     */
    public function removeFromCart(Request $request, $cartId)
    {
        $cartItem = $this->getUserCartItem(
            $request->user()->id,
            $cartId
        );

        $cartItem->delete();

        return redirect()
            ->route('user.cart')
            ->with('success', 'Product removed from cart.');
    }

    /**
     * Update cart item quantity.
     */
    public function updateQuantity(Request $request, $cartId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:10',
        ]);

        $cartItem = $this->getUserCartItemWithProduct(
            $request->user()->id,
            $cartId
        );

        $quantity = (int) $request->quantity;

        if ($quantity > $cartItem->product->stock) {
            return $this->redirectBackWithError(
                'You cannot add more than the available stock. Only ' .
                $cartItem->product->stock . ' items available.'
            );
        }

        $cartItem->update([
            'quantity' => $quantity,
        ]);

        return redirect()
            ->route('user.cart')
            ->with('success', 'Cart quantity updated.');
    }

    /**
     * Clear all items from cart.
     */
    public function clearCart(Request $request)
    {
        $deleted = $request->user()->carts()->delete();

        if ($deleted > 0) {
            return redirect()
                ->route('user.cart')
                ->with('success', 'Cart cleared successfully.');
        }

        return redirect()
            ->route('user.cart')
            ->with('error', 'Your cart is already empty.');
    }

    /**
     * Get cart item count for header/navigation.
     */
    public function getCartCount(Request $request)
    {
        $count = $request->user()
            ? $request->user()->carts()->sum('quantity')
            : 0;

        return response()->json(['count' => $count]);
    }

    /**
     * Calculate subtotal of cart items.
     */
    private function calculateSubtotal($cartItems): float
    {
        return (float) $cartItems->sum(
            fn ($item) => $item->price * $item->quantity
        );
    }

    /**
     * Check if user's default address is inside Kathmandu Valley.
     */
    private function isInsideKathmanduValley($user): bool
    {
        $address = $user
            ->addresses()
            ->where('is_default', true)
            ->first();

        if (!$address) {
            return false;
        }

        $district = strtolower(trim($address->district ?? ''));
        $city = strtolower(trim($address->city ?? ''));

        // Check exact matches first (more reliable)
        if (in_array($district, self::VALLEY_DISTRICTS)) {
            return true;
        }

        if (in_array($city, self::VALLEY_CITIES)) {
            return true;
        }

        // Fallback to partial match for cases like "Kathmandu-01"
        foreach (self::VALLEY_DISTRICTS as $valleyDistrict) {
            if (str_contains($district, $valleyDistrict)) {
                return true;
            }
        }

        foreach (self::VALLEY_CITIES as $valleyCity) {
            if (str_contains($city, $valleyCity)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Calculate delivery charge based on subtotal and location.
     */
    private function calculateDeliveryCharge(
        float $subtotal,
        bool $isInsideValley
    ): float {
        $tiers = $isInsideValley ? [
            10000 => 0,    // Free delivery
            5000  => 80,
            2000  => 100,
            1000  => 120,
            0     => 150,
        ] : [
            10000 => 100,
            5000  => 200,
            2000  => 300,
            1000  => 400,
            0     => 500,
        ];

        foreach ($tiers as $threshold => $charge) {
            if ($subtotal >= $threshold) {
                return (float) $charge;
            }
        }

        return 0.0;
    }

    /**
     * Calculate tax amount.
     */
    private function calculateTax(float $subtotal, float $taxRate): float
    {
        return round($subtotal * ($taxRate / 100), 2);
    }

    /**
     * Get product price (discount price when available).
     */
    private function getProductPrice($product): float
    {
        return (float) ($product->discount_price ?? $product->price);
    }

    /**
     * Get existing cart item.
     */
    private function getCartItem(
        int $userId,
        int $productId,
        ?int $variantId = null
    ) {
        return Cart::where('user_id', $userId)
            ->where('product_id', $productId)
            ->where('variant_id', $variantId)
            ->first();
    }

    /**
     * Create new cart item.
     */
    private function createCartItem(
        int $userId,
        int $productId,
        ?int $variantId,
        int $quantity,
        $product
    ): void {
        Cart::create([
            'user_id' => $userId,
            'product_id' => $productId,
            'variant_id' => $variantId,
            'quantity' => $quantity,
            'price' => $this->getProductPrice($product),
        ]);
    }

    /**
     * Get user's cart item.
     */
    private function getUserCartItem(
        int $userId,
        int $cartId
    ) {
        return Cart::where('id', $cartId)
            ->where('user_id', $userId)
            ->firstOrFail();
    }

    /**
     * Get user's cart item with product relation.
     */
    private function getUserCartItemWithProduct(
        int $userId,
        int $cartId
    ) {
        return Cart::where('id', $cartId)
            ->where('user_id', $userId)
            ->with('product')
            ->firstOrFail();
    }

    /**
     * Redirect back with error message.
     */
    private function redirectBackWithError(string $message)
    {
        return back()->with('error', $message);
    }


}
