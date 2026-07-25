<?php

use App\Http\Controllers\Frontend\PageController;
use Illuminate\Support\Facades\Route;


//Route::get('/', function () {
   // return view('welcome');
//});

Route::get('/', [PageController::class, 'home'])->name('home');

Route::get('/limited-time-offer', [PageController::class, 'LimitedTimeOffer'])->name('limited-time-offer');

Route::get('/new-product', [PageController::class, 'NewProduct'])->name('new-product');
