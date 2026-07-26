<?php

use App\Http\Controllers\Frontend\PageController;
use Illuminate\Support\Facades\Route;


//Route::get('/', function () {
   // return view('welcome');
//});

Route::get('/', [PageController::class, 'home'])->name('home');

Route::prefix('todays-deals')->group(function () {

    Route::get('/limited-time-offer', [PageController::class, 'limitedTimeOffer'])
        ->name('limited-time-offer');

    Route::get('/new-product', [PageController::class, 'newProduct'])
        ->name('new-product');

});
