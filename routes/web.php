<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\PageController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [PageController::class, 'home'])->name('home');
