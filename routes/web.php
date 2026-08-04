<?php

use App\Http\Controllers\Frontend\PageController;
use Illuminate\Support\Facades\Route;


//Route::get('/', function () {
   // return view('welcome');
//});

Route::get('/', [PageController::class, 'home'])->name('home');

Route::get('/privacy-policy', [PageController::class, 'privacypolicy'])->name('privacy-policy');
Route::get('/refund-policy', [PageController::class, 'refundpolicy'])->name('refund-policy');
Route::get('/terms-of-service', [PageController::class, 'termsofservice'])->name('terms-of-service');
Route::get('/contact-us', [PageController::class, 'contactus'])->name('contact-us');
