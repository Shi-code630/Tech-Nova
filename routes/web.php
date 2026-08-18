<?php

use App\Http\Controllers\BrandController; // agar BrandController hai
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\UserDashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserOrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;

//Route::get('/', function () {
   // return view('welcome');
//});

Route::get('/', [PageController::class, 'home'])->name('home');



Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');

// ==================== AUTHENTICATION ====================

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.submit');

Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register.submit');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

        //MIDDLEWARE ROUTE GROUP FOR AUTHENTICATED USERS \\

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [UserDashboardController::class, 'index'])
        ->name('user.dashboard');

    Route::get('/dashboard/profile', function () {
        return view('user.profile');
    })->name('user.profile');


    Route::get('/my-orders/{order}', [UserOrderController::class, 'show'])
        ->name('user.order.view');

    Route::get('/my-orders', [UserOrderController::class, 'index'])
        ->name('user.orders');

    Route::get('/my-orders/{order}/track', [UserOrderController::class, 'track'])
        ->name('user.order.track');


    Route::post('/cart/add/{product}', [CartController::class, 'addToCart'])
        ->name('cart.add');

    Route::get('/cart', [CartController::class, 'index'])
        ->name('user.cart');

    Route::delete('/cart/remove/{cart}', [CartController::class, 'removeFromCart'])
        ->name('cart.remove');

    Route::patch('/cart/update/{cart}', [CartController::class, 'updateQuantity'])
        ->name('cart.update');



    Route::get('/checkout', [CheckoutController::class, 'index'])
        ->name('checkout');

    Route::get('/checkout/address/create', [CheckoutController::class, 'createAddress'])
        ->name('checkout.address.create');

    Route::post('/checkout/address', [CheckoutController::class, 'storeAddress'])
        ->name('checkout.address.store');




        Route::get('/wishlist', function () {
            return view('user.wishlist.index');
        })->name('user.wishlist');



        Route::get('/addresses', function () {
        return view('user.addresses.index');
        })->name('user.addresses');


        Route::get('/reviews', function () {
        return view('user.reviews.index');
        })->name('user.reviews');

        Route::get('/coupons', function () {
        return view('user.coupons.index');
        })->name('user.coupons');

        Route::get('/settings', function () {
        return view('user.settings');
        })->name('user.settings');


});

Route::get('/brand/{slug}', [PageController::class, 'show'])->name('brand.show');

  Route::get('/today-deals', [CategoryController::class, 'todayDeals'])
    ->name('today-deals');

Route::get('/category/{slug}', [CategoryController::class, 'show'])
    ->name('category.show');

Route::get('/product/{slug}', [ProductController::class, 'show'])
    ->name('product.show');




Route::get('/privacy-policy', [PageController::class, 'privacypolicy'])->name('privacy-policy');
Route::get('/refund-policy', [PageController::class, 'refundpolicy'])->name('refund-policy');
Route::get('/terms-of-service', [PageController::class, 'termsofservice'])->name('terms-of-service');
Route::get('/contact-us', [PageController::class, 'contactus'])->name('contact-us');
Route::get('/warranty-policy', [PageController::class, 'warrantypolicy'])->name('warranty-policy');
Route::get('/careers', [PageController::class, 'careers'])->name('careers');



