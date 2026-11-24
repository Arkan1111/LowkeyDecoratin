<?php

use App\Http\Controllers\Auth\CustomerLoginController;
use App\Http\Controllers\Auth\CustomerRegisterController;
use App\Http\Controllers\Auth\AdminLoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// BERANDA PUBLIK (LANDING PAGE CUSTOMER)
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

// ADMIN
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::view('/paket', 'admin.packages.index')->name('packages');
    Route::view('/reservasi', 'admin.reservations.index')->name('reservations');
    Route::view('/portofolio', 'admin.portfolio.index')->name('portfolio');
    Route::view('/pengguna', 'admin.users.index')->name('users');
});

// KEUANGAN
Route::middleware(['auth', 'role:keuangan'])->prefix('keuangan')->name('keuangan.')->group(function () {
    Route::get('/dashboard', function () {
        return view('keuangan.dashboard');
    })->name('dashboard');
});
