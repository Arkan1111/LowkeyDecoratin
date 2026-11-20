<?php

use App\Http\Controllers\Auth\CustomerLoginController;
use App\Http\Controllers\Auth\CustomerRegisterController;
use App\Http\Controllers\Auth\AdminLoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// BERANDA PUBLIK
Route::get('/', function () {
    return view('customer.home');
})->name('home');

// ==========================================
// ROUTE GUEST (HANYA UNTUK PENGGUNA BELUM LOGIN)
// ==========================================
Route::middleware('guest')->group(function () {
    // LOGIN CUSTOMER
    Route::get('/login', [CustomerLoginController::class, 'create'])->name('login');
    Route::post('/login', [CustomerLoginController::class, 'store'])
        ->middleware('throttle:5,1')
        ->name('customer.login.store');

    // REGISTER CUSTOMER
    Route::get('/register', [CustomerRegisterController::class, 'create'])->name('register');
    Route::post('/register', [CustomerRegisterController::class, 'store'])
        ->middleware('throttle:5,1')
        ->name('register.store');

    // LOGIN ADMIN & KEUANGAN (PORTAL INTERNAL)
    Route::get('/admin/login', [AdminLoginController::class, 'create'])->name('admin.login');
    Route::post('/admin/login', [AdminLoginController::class, 'store'])
        ->middleware('throttle:5,1')
        ->name('admin.login.store');
});

// ==========================================
// ROUTE LOGOUT (UNTUK SEMUA ROLE YANG LOGIN)
// ==========================================
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login')->with('status', 'Anda telah berhasil keluar.');
})->middleware('auth')->name('logout');

// ==========================================
// ROUTE TERPROTEKSI SESUAI ROLE
// ==========================================

// 1. CUSTOMER
Route::middleware(['auth', 'role:customer'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', function () {
        return view('customer.dashboard');
    })->name('dashboard');
});

// 2. ADMIN
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
});

// 3. KEUANGAN
Route::middleware(['auth', 'role:keuangan'])->prefix('keuangan')->name('keuangan.')->group(function () {
    Route::get('/dashboard', function () {
        return view('keuangan.dashboard');
    })->name('dashboard');
});