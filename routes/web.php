<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReturnRequestController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\UserOrderController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/search', [PageController::class, 'search'])->name('search');

//SEO SITEMAP//

Route::get('/sitemap.xml', function () {
    while (ob_get_level() > 0) {
        ob_end_clean();
    }

    if (class_exists(\Barryvdh\Debugbar\Facade::class)) {
        \Barryvdh\Debugbar\Facade::disable();
    }

    $item = function ($loc, $lastmod, $freq, $priority) {
        $last = $lastmod ? $lastmod->toAtomString() : now()->toAtomString();

        return '<url><loc>' . htmlspecialchars($loc, ENT_XML1)
            . '</loc><lastmod>' . $last
            . '</lastmod><changefreq>' . $freq
            . '</changefreq><priority>' . $priority
            . '</priority></url>';
    };

    $body = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'
        . $item(route('home'), now(), 'daily', '1.0')
        . $item(route('blogs.index'), now(), 'weekly', '0.6');

    foreach (\App\Models\Category::where('status', true)->get(['slug', 'updated_at']) as $category) {
        $body .= $item(route('category.show', $category->slug), $category->updated_at, 'weekly', '0.8');
    }
    foreach (\App\Models\Brand::where('status', true)->get(['slug', 'updated_at']) as $brand) {
        $body .= $item(url('/brand/' . $brand->slug), $brand->updated_at, 'weekly', '0.7');
    }
    foreach (\App\Models\Product::where('status', 'active')->get(['slug', 'updated_at']) as $product) {
        $body .= $item(route('product.show', $product->slug), $product->updated_at, 'weekly', '0.9');
    }
    foreach (\App\Models\Blog::where('is_published', true)->get(['slug', 'updated_at']) as $blog) {
        $body .= $item(route('blogs.view', $blog->slug), $blog->updated_at, 'monthly', '0.5');
    }
    $body .= '</urlset>';

    return response($body, 200)->header('Content-Type', 'application/xml; charset=UTF-8');
})->name('sitemap');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/contact-us', [PageController::class, 'contactus'])->name('contact-us');
Route::post('/contact-us', [ContactMessageController::class, 'store'])->name('contact-us.store');
Route::get('/contact', [ContactMessageController::class, 'create'])->name('contact.create');
Route::post('/contact', [ContactMessageController::class, 'store'])->name('contact.store');

Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blogs.view');

/*
|--------------------------------------------------------------------------
| Products & Categories
|--------------------------------------------------------------------------
*/
Route::get('/brand/{slug}', [PageController::class, 'show'])->name('brand.show');
Route::get('/brands', [BrandController::class, 'index'])
    ->name('brands.all');
Route::get('/today-deals', [CategoryController::class, 'todayDeals'])->name('today-deals');

Route::get('/today-deals/festive/{slug}', [CategoryController::class, 'festive'])
    ->name('frontend.today-deals.festive');

Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show');

Route::get('/limited-time', [CategoryController::class, 'limitedTime']) ->name('limited-time');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');

Route::get('/privacy-policy', [PageController::class, 'privacypolicy'])->name('privacy-policy');
Route::get('/refund-policy', [PageController::class, 'refundpolicy'])->name('refund-policy');
Route::get('/terms-of-service', [PageController::class, 'termsofservice'])->name('terms-of-service');
Route::get('/warranty-policy', [PageController::class, 'warrantypolicy'])->name('warranty-policy');
Route::get('/careers', [PageController::class, 'careers'])->name('careers');
Route::post('/careers/apply', [JobApplicationController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('careers.apply');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
    Route::get('/dashboard/profile', function () {
        return view('user.profile');
    })->name('user.profile');
    Route::put('/dashboard/profile', [AuthController::class, 'updateProfile'])->name('user.profile.update');

    Route::get('/my-orders', [UserOrderController::class, 'index'])->name('user.orders');
    Route::get('/my-orders/{order}', [UserOrderController::class, 'show'])->name('user.order.view');
    Route::get('/my-orders/{order}/track', [UserOrderController::class, 'track'])->name('user.order.track');
    Route::get('/my-orders/{order}/return-exchange', [ReturnRequestController::class, 'create'])
        ->name('return-requests.create');
    Route::post('/my-orders/{order}/return-exchange', [ReturnRequestController::class, 'store'])
        ->middleware('throttle:5,1')
        ->name('return-requests.store');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/track', [OrderController::class, 'track'])->name('orders.track');
    Route::get('/orders/{order}/review', [OrderController::class, 'review'])->name('orders.review');
    Route::post('/orders/{order}/review', [OrderController::class, 'submitReview'])->name('orders.review.submit');
    Route::put('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');

    Route::get('/cart', [CartController::class, 'index'])->name('user.cart');
    Route::post('/cart/add/{product}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::patch('/cart/update/{cart}', [CartController::class, 'updateQuantity'])->name('cart.update');
    Route::delete('/cart/remove/{cart}', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::delete('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout/continue', [CheckoutController::class, 'continueCheckout'])->name('checkout.continue');
    Route::get('/checkout/confirm', [CheckoutController::class, 'confirm'])->name('checkout.confirm');
    Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.place-order');
    Route::post('/checkout/coupon', [CouponController::class, 'apply'])->name('checkout.coupon.apply');
    Route::delete('/checkout/coupon', [CouponController::class, 'remove'])->name('checkout.coupon.remove');

    Route::get('/my-addresses', [CheckoutController::class, 'addresses'])->name('checkout.addresses');
    Route::delete('/my-addresses/{id}', [CheckoutController::class, 'deleteAddress'])->name('checkout.address.delete');
    Route::get('/checkout/address/create', [CheckoutController::class, 'createAddress'])->name('checkout.address.create');
    Route::post('/checkout/address', [CheckoutController::class, 'storeAddress'])->name('checkout.address.store');
    Route::get('/checkout/address/{id}/edit', [CheckoutController::class, 'editAddress'])->name('checkout.address.edit');
    Route::put('/checkout/address/{id}', [CheckoutController::class, 'updateAddress'])->name('checkout.address.update');

    Route::get('/wishlist', [WishlistController::class, 'index'])->name('user.wishlist');
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('user.wishlist.toggle');
    Route::delete('/wishlist/{productId}', [WishlistController::class, 'destroy'])->name('user.wishlist.remove');
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])
        ->name('wishlist.toggle');

    Route::get('/reviews', [UserDashboardController::class, 'reviews'])->name('user.reviews');
    Route::get('/coupons', [CouponController::class, 'index'])->name('user.coupons');
    Route::get('/settings', [UserDashboardController::class, 'settings'])->name('user.settings');
    Route::get('/coins', [UserDashboardController::class, 'coins'])->name('user.coins');
    Route::get('/user/coins/live', [UserDashboardController::class, 'liveCoins'])->name('user.coins.live');
});


Route::post('/careers/apply', [\App\Http\Controllers\JobApplicationController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('careers.apply');


Route::get('/settings', [UserDashboardController::class, 'settings'])
    ->name('user.settings');

Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('user.wishlist.toggle');

Route::get('/today-deals', [CategoryController::class, 'todayDeals'])
    ->name('today-deals');

Route::get('/today-deals/festive/{slug}', [CategoryController::class, 'festive'])
    ->name('frontend.today-deals.festive');

Route::get('/limited-time', [CategoryController::class, 'limitedTime'])
    ->name('limited-time');

Route::get('/category/{slug}', [CategoryController::class, 'show'])
    ->name('category.show');
