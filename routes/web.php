<?php

use App\Http\Controllers\Auth\CustomerLoginController;
use App\Http\Controllers\Auth\AdminLoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('customer.home');
});

// LOGIN
Route::middleware('guest')->group(function () {

    // LOGIN CUSTOMER
    Route::get('/login', [CustomerLoginController::class, 'create'])
        ->name('login');

    Route::post('/login', [CustomerLoginController::class, 'store'])
        ->middleware('throttle:5,1')
        ->name('customer.login.store');


    // LOGIN ADMIN / STAFF
    Route::get('/admin/login', [AdminLoginController::class, 'create'])
        ->name('admin.login');

    Route::post('/admin/login', [AdminLoginController::class, 'store'])
        ->middleware('throttle:5,1')
        ->name('admin.login.store');
});
