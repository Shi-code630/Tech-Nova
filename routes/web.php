<?php

use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\UserDashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserOrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReturnRequestController;

use App\Http\Controllers\CouponController;


// ==================== HOME ====================
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/search', [PageController::class, 'search'])->name('search');

// ==================== AUTHENTICATION ====================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ==================== CONTACT PAGE ====================
Route::get('/contact-us', [PageController::class, 'contactus'])->name('contact-us');
Route::post('/contact-us', [ContactMessageController::class, 'store'])->name('contact-us.store');
Route::controller(ContactMessageController::class)->group(function () {
    Route::get('/contact', 'create')->name('contact.create');
    Route::post('/contact', 'store')->name('contact.store');
});

// ==================== BLOG ROUTES ====================
Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blogs.view');

// ==================== PRODUCTS & CATEGORIES ====================
Route::get('/brand/{slug}', [PageController::class, 'show'])->name('brand.show');
Route::get('/today-deals', [CategoryController::class, 'todayDeals'])->name('today-deals');
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');

// ==================== STATIC PAGES ====================
Route::get('/privacy-policy', [PageController::class, 'privacypolicy'])->name('privacy-policy');
Route::get('/refund-policy', [PageController::class, 'refundpolicy'])->name('refund-policy');
Route::get('/terms-of-service', [PageController::class, 'termsofservice'])->name('terms-of-service');
Route::get('/warranty-policy', [PageController::class, 'warrantypolicy'])->name('warranty-policy');
Route::get('/careers', [PageController::class, 'careers'])->name('careers');

// ==================== AUTHENTICATED ROUTES ====================
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
    Route::get('/dashboard/profile', function () {
        return view('user.profile');
    })->name('user.profile');

    // User Orders (My Orders)
    Route::get('/my-orders', [UserOrderController::class, 'index'])->name('user.orders');
    Route::get('/my-orders/{order}', [UserOrderController::class, 'show'])->name('user.order.view');
    Route::get('/my-orders/{order}/track', [UserOrderController::class, 'track'])->name('user.order.track');

    // Cart Routes
    Route::post('/cart/add/{product}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'index'])->name('user.cart');
    Route::delete('/cart/remove/{cart}', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::patch('/cart/update/{cart}', [CartController::class, 'updateQuantity'])->name('cart.update');
    Route::delete('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');

    // Checkout Routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::get('/checkout/address/create', [CheckoutController::class, 'createAddress'])->name('checkout.address.create');
    Route::post('/checkout/address', [CheckoutController::class, 'storeAddress'])->name('checkout.address.store');
    Route::post('/checkout/continue', [CheckoutController::class, 'continueCheckout'])->name('checkout.continue');
    Route::get('/checkout/confirm', [CheckoutController::class, 'confirm'])->name('checkout.confirm');
    Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.place-order');

    Route::middleware('auth')->group(function () {
    Route::get('/addresses/{id}/edit',[CheckoutController::class, 'editAddress'])->name('checkout.address.edit');

    Route::put('/addresses/{id}',[CheckoutController::class, 'updateAddress'])->name('checkout.address.update');

});

    // Order Routes (User)
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/track', [OrderController::class, 'track'])->name('orders.track');
    Route::get('/orders/{order}/review', [OrderController::class, 'review'])->name('orders.review');
    Route::post('/orders/{order}/review', [OrderController::class, 'submitReview'])->name('orders.review.submit');
    Route::put('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');

    Route::get('/my-orders/{order}/return-exchange', [ReturnRequestController::class, 'create'])->name('return-requests.create');
    Route::post('/my-orders/{order}/return-exchange', [ReturnRequestController::class, 'store'])->middleware('throttle:5,1')->name('return-requests.store');


    Route::get('/wishlist', function () {
        return view('user.wishlist.index');
    })->name('user.wishlist');

    Route::post('/cart/add/{product}', [CartController::class, 'addToCart'])->name('cart.add');

    Route::get('/cart', [CartController::class, 'index'])->name('user.cart');

    Route::delete('/cart/remove/{cart}', [CartController::class, 'removeFromCart'])->name('cart.remove');

    Route::patch('/cart/update/{cart}', [CartController::class, 'updateQuantity'])->name('cart.update');



    Route::get('/checkout', [CheckoutController::class, 'index'])
        ->name('checkout');

    Route::get('/checkout/address/create', [CheckoutController::class, 'createAddress'])
        ->name('checkout.address.create');

    Route::post('/checkout/address', [CheckoutController::class, 'storeAddress'])
        ->name('checkout.address.store');

    Route::post('/checkout/continue', [CheckoutController::class, 'continueCheckout'])
        ->name('checkout.continue');

    Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])
        ->name('checkout.place-order');




    Route::get('/wishlist', function () {
        return view('user.wishlist.index');
    })->name('user.wishlist');



    Route::get('/addresses', function () {
        return view('user.addresses.index');
    })->name('user.addresses');


    Route::get('/reviews', function () {
        return view('user.reviews.index');
    })->name('user.reviews');


    Route::get('/coupons', [CouponController::class, 'index'])->name('user.coupons');
    Route::post('/checkout/coupon', [CouponController::class, 'apply'])->name('checkout.coupon.apply');
    Route::delete('/checkout/coupon', [CouponController::class, 'remove'])->name('checkout.coupon.remove');


    Route::get('/settings', function () {
        return view('user.settings');
    })->name('user.settings');

    Route::get('/coins', function () {
        $user = request()->user();

        return view('user.coins.index', [
            'coinSummary' => \App\Helpers\RewardHelper::getUserCoinsSummary($user),
            'transactions' => $user->rewardTransactions()->latest()->paginate(20),
        ]);
    })->name('user.coins');


    Route::get('/user/coins/live', [UserDashboardController::class, 'liveCoins'])
        ->name('user.coins.live');
});






Route::middleware('auth')->group(function () {

    Route::put(
        '/dashboard/profile',
        [AuthController::class, 'updateProfile']
    )->name('user.profile.update');

});

Route::middleware('auth')->group(function () {

    // My Addresses
    Route::get('/my-addresses', [CheckoutController::class, 'addresses'])
        ->name('checkout.addresses');

    // Add Address
    Route::get('/checkout/address', [CheckoutController::class, 'createAddress'])
        ->name('checkout.address.create');

    // Save Address
    Route::post('/checkout/address', [CheckoutController::class, 'storeAddress'])
        ->name('checkout.address.store');

    // Edit Address
    Route::get('/checkout/address/{id}/edit', [CheckoutController::class, 'editAddress'])
        ->name('checkout.address.edit');

    // Update Address
    Route::put('/checkout/address/{id}', [CheckoutController::class, 'updateAddress'])
        ->name('checkout.address.update');

    // Delete Address
    Route::delete('/my-addresses/{id}', [CheckoutController::class, 'deleteAddress'])
        ->name('checkout.address.delete');

});

Route::get('/reviews', [UserDashboardController::class, 'reviews'])
    ->middleware('auth')
    ->name('user.reviews');




Route::middleware('auth')->group(function () {

    // Wishlist page
    Route::get('/wishlist', [WishlistController::class, 'index'])
        ->name('user.wishlist');

    // Add / remove wishlist
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])
        ->name('user.wishlist.toggle');

    // Remove from wishlist page
    Route::delete('/wishlist/{productId}', [WishlistController::class, 'destroy'])
        ->name('user.wishlist.remove');

});
