<?php

use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReturnRequestController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\UserOrderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Home
|--------------------------------------------------------------------------
*/
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/search', [PageController::class, 'search'])->name('search');

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Contact
|--------------------------------------------------------------------------
*/
Route::get('/contact-us', [PageController::class, 'contactus'])->name('contact-us');
Route::post('/contact-us', [ContactMessageController::class, 'store'])->name('contact-us.store');

Route::controller(ContactMessageController::class)->group(function () {
    Route::get('/contact', 'create')->name('contact.create');
    Route::post('/contact', 'store')->name('contact.store');
});

/*
|--------------------------------------------------------------------------
| Blog
|--------------------------------------------------------------------------
*/
Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blogs.view');

/*
|--------------------------------------------------------------------------
| Products & Categories
|--------------------------------------------------------------------------
*/
Route::get('/brand/{slug}', [PageController::class, 'show'])->name('brand.show');
Route::get('/today-deals', [CategoryController::class, 'todayDeals'])->name('today-deals');
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');

/*
|--------------------------------------------------------------------------
| Static Pages
|--------------------------------------------------------------------------
*/
Route::get('/privacy-policy', [PageController::class, 'privacypolicy'])->name('privacy-policy');
Route::get('/refund-policy', [PageController::class, 'refundpolicy'])->name('refund-policy');
Route::get('/terms-of-service', [PageController::class, 'termsofservice'])->name('terms-of-service');
Route::get('/warranty-policy', [PageController::class, 'warrantypolicy'])->name('warranty-policy');
Route::get('/careers', [PageController::class, 'careers'])->name('careers');


// ==================== CAREERS ✅ ====================
Route::get('/careers', [PageController::class, 'careers'])->name('careers');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    /*
    |----------------------------------------------------------------------
    | Dashboard / Profile
    |----------------------------------------------------------------------
    */
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
    Route::get('/dashboard/profile', function () {
        return view('user.profile');
    })->name('user.profile');
    Route::put('/dashboard/profile', [AuthController::class, 'updateProfile'])->name('user.profile.update');

    /*
    |----------------------------------------------------------------------
    | My Orders (user-facing order history)
    |----------------------------------------------------------------------
    */
    Route::get('/my-orders', [UserOrderController::class, 'index'])->name('user.orders');
    Route::get('/my-orders/{order}', [UserOrderController::class, 'show'])->name('user.order.view');
    Route::get('/my-orders/{order}/track', [UserOrderController::class, 'track'])->name('user.order.track');

    Route::get('/my-orders/{order}/return-exchange', [ReturnRequestController::class, 'create'])
        ->name('return-requests.create');
    Route::post('/my-orders/{order}/return-exchange', [ReturnRequestController::class, 'store'])
        ->middleware('throttle:5,1')
        ->name('return-requests.store');

    /*
    |----------------------------------------------------------------------
    | Orders (review, cancel, track)
    |----------------------------------------------------------------------
    */
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/track', [OrderController::class, 'track'])->name('orders.track');
    Route::get('/orders/{order}/review', [OrderController::class, 'review'])->name('orders.review');
    Route::post('/orders/{order}/review', [OrderController::class, 'submitReview'])->name('orders.review.submit');
    Route::put('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');

    /*
    |----------------------------------------------------------------------
    | Cart
    |----------------------------------------------------------------------
    */
    Route::get('/cart', [CartController::class, 'index'])->name('user.cart');
    Route::post('/cart/add/{product}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::patch('/cart/update/{cart}', [CartController::class, 'updateQuantity'])->name('cart.update');
    Route::delete('/cart/remove/{cart}', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::delete('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');

    /*
    |----------------------------------------------------------------------
    | Checkout
    |----------------------------------------------------------------------
    */
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout/continue', [CheckoutController::class, 'continueCheckout'])->name('checkout.continue');
    Route::get('/checkout/confirm', [CheckoutController::class, 'confirm'])->name('checkout.confirm');
    Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.place-order');

    /*
    |----------------------------------------------------------------------
    | Addresses
    |----------------------------------------------------------------------
    */
    // ✅ Single route with both names
    Route::get('/my-addresses', [CheckoutController::class, 'addresses'])->name('user.addresses');
    Route::get('/my-addresses', [CheckoutController::class, 'addresses'])->name('checkout.addresses');

    // Address CRUD
    Route::delete('/my-addresses/{id}', [CheckoutController::class, 'deleteAddress'])->name('checkout.address.delete');
    Route::get('/checkout/address/create', [CheckoutController::class, 'createAddress'])->name('checkout.address.create');
    Route::post('/checkout/address', [CheckoutController::class, 'storeAddress'])->name('checkout.address.store');
    Route::get('/checkout/address/{id}/edit', [CheckoutController::class, 'editAddress'])->name('checkout.address.edit');
    Route::put('/checkout/address/{id}', [CheckoutController::class, 'updateAddress'])->name('checkout.address.update');

    /*
    |----------------------------------------------------------------------
    | Wishlist / Reviews / Coupons / Settings / Coins
    |----------------------------------------------------------------------
    */
    Route::get('/wishlist', function () {
        return view('user.wishlist.index');
    })->name('user.wishlist');

    Route::get('/reviews', [UserDashboardController::class, 'reviews'])->name('user.reviews');

    Route::get('/coupons', function () {
        return view('user.coupons.index');
    })->name('user.coupons');

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

    Route::get('/user/coins/live', [UserDashboardController::class, 'liveCoins'])->name('user.coins.live');
});
