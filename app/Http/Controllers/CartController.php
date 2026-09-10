<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

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
        'kathmandu',
        'lalitpur',
        'bhaktapur',
        'patan',
        'kirtipur',
        'madhyapur thimi',
        'thimi',
        'madhyapur'
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
            'taxRate'
        ));
    }

    /**
     * Add product to cart.
     */
    public function addToCart(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:10',
            // Table is "product_variants" (not "variants"), and the variant
            // must actually belong to the product being added.
            'variant_id' => [
                'nullable',
                Rule::exists('product_variants', 'id')->where(
                    fn($query) => $query->where('product_id', $productId)
                ),
            ],
        ]);

        try {
            $user = $request->user();
            $product = Product::findOrFail($productId);
            $quantity = (int) $request->quantity;

            // Product active check
            if ($product->status !== 'active') {
                return $this->redirectBackWithError(
                    'This product is currently not available.'
                );
            }

            $variantId = $request->variant_id;
            $variant = $variantId
                ? ProductVariant::where('id', $variantId)
                    ->where('product_id', $product->id)
                    ->first()
                : null;

            if ($variantId && !$variant) {
                return $this->redirectBackWithError(
                    'Selected variant is no longer available.'
                );
            }

            if ($variant && !$variant->status) {
                return $this->redirectBackWithError(
                    'This variant is currently not available.'
                );
            }

            // Stock check — variant stock when a variant is selected,
            // product stock otherwise.
            $availableStock = $this->getEffectiveStock($product, $variant);

            if ($availableStock < $quantity) {
                return $this->redirectBackWithError(
                    'Not enough stock available. Only ' . $availableStock . ' items left.'
                );
            }

            $cart = $this->getCartItem(
                $user->id,
                $product->id,
                $variantId
            );

            if ($cart) {
                $newQuantity = $cart->quantity + $quantity;

                if ($newQuantity > $availableStock) {
                    return $this->redirectBackWithError(
                        'You cannot add more than the available stock.'
                    );
                }

                $cart->update([
                    'quantity' => $newQuantity,
                    'price' => $this->getEffectivePrice($product, $variant),
                ]);
            } else {
                $this->createCartItem(
                    $user->id,
                    $product->id,
                    $variantId,
                    $quantity,
                    $product,
                    $variant
                );
            }

            return redirect()
                ->route('user.cart')
                ->with('success', 'Product added to cart successfully.');

        } catch (\Exception $e) {
            Log::error('Add to cart error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
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

        // Variant stock when the cart line has a variant, product stock otherwise.
        $availableStock = $this->getEffectiveStock($cartItem->product, $cartItem->variant);

        if ($quantity > $availableStock) {
            return $this->redirectBackWithError(
                'You cannot add more than the available stock. Only ' .
                    $availableStock . ' items available.'
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
            fn($item) => $item->price * $item->quantity
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

        if (in_array($district, self::VALLEY_DISTRICTS)) {
            return true;
        }

        if (in_array($city, self::VALLEY_CITIES)) {
            return true;
        }

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
     * Get the stock that actually applies to this cart line —
     * the variant's stock when a variant is selected, the product's
     * own stock otherwise. Matches how CheckoutController decrements stock.
     */
    private function getEffectiveStock($product, ?ProductVariant $variant): int
    {
        return $variant ? (int) $variant->stock : (int) $product->stock;
    }

    /**
     * Get the price that actually applies to this cart line —
     * the variant's own price when a variant is selected and priced,
     * otherwise the product's discount price (or regular price).
     */
    private function getEffectivePrice($product, ?ProductVariant $variant): float
    {
        if ($variant && $variant->price > 0) {
            return (float) $variant->price;
        }

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
        $product,
        ?ProductVariant $variant = null
    ): void {
        Cart::create([
            'user_id' => $userId,
            'product_id' => $productId,
            'variant_id' => $variantId,
            'quantity' => $quantity,
            'price' => $this->getEffectivePrice($product, $variant),
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
     * Get user's cart item with product and variant relations.
     */
    private function getUserCartItemWithProduct(
        int $userId,
        int $cartId
    ) {
        return Cart::where('id', $cartId)
            ->where('user_id', $userId)
            ->with(['product', 'variant'])
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