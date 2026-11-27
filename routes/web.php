
<?php

use App\Http\Controllers\Auth\CustomerLoginController;
use App\Http\Controllers\Auth\CustomerRegisterController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\CustomerQuotaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


// ==========================================
// BERANDA PUBLIK (LANDING PAGE CUSTOMER)
// ==========================================

Route::get('/', function () {
    return view('customer.home');
})->name('home');


// ==========================================
// CEK KUOTA CUSTOMER
// Bisa diakses sebelum maupun sesudah login
// ==========================================

Route::get('/cek-kuota', [
    CustomerQuotaController::class,
    'index'
])->name('customer.cek-kuota');


// ==========================================
// ROUTE GUEST
// HANYA UNTUK PENGGUNA BELUM LOGIN
// ==========================================

Route::middleware('guest')->group(function () {

    // LOGIN CUSTOMER
    Route::get('/login', [
        CustomerLoginController::class,
        'create'
    ])->name('login');

    Route::post('/login', [
        CustomerLoginController::class,
        'store'
    ])->middleware('throttle:5,1')
      ->name('customer.login.store');


    // REGISTER CUSTOMER
    Route::get('/register', [
        CustomerRegisterController::class,
        'create'
    ])->name('register');

    Route::post('/register', [
        CustomerRegisterController::class,
        'store'
    ])->middleware('throttle:5,1')
      ->name('register.store');


    // LOGIN ADMIN & KEUANGAN
    Route::get('/admin/login', [
        AdminLoginController::class,
        'create'
    ])->name('admin.login');

    Route::post('/admin/login', [
        AdminLoginController::class,
        'store'
    ])->middleware('throttle:5,1')
      ->name('admin.login.store');

});


// ==========================================
// LOGOUT
// ==========================================

Route::post('/logout', function (Request $request) {

    Auth::logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect('/login')->with(
        'status',
        'Anda telah berhasil keluar.'
    );

})->middleware('auth')->name('logout');


// ==========================================
// DASHBOARD ADMIN
// ==========================================

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/paket', [\App\Http\Controllers\Admin\PackageController::class, 'index'])
            ->name('packages');
        Route::post('/paket', [\App\Http\Controllers\Admin\PackageController::class, 'store'])
            ->name('packages.store');
        Route::put('/paket/{package}', [\App\Http\Controllers\Admin\PackageController::class, 'update'])
            ->name('packages.update');
        Route::delete('/paket/{package}', [\App\Http\Controllers\Admin\PackageController::class, 'destroy'])
            ->name('packages.destroy');
        Route::patch('/paket/{package}/toggle-status', [\App\Http\Controllers\Admin\PackageController::class, 'toggleStatus'])
            ->name('packages.toggle-status');

        Route::get('/reservasi', [\App\Http\Controllers\Admin\ReservationController::class, 'index'])
            ->name('reservations');
        Route::post('/reservasi', [\App\Http\Controllers\Admin\ReservationController::class, 'store'])
            ->name('reservations.store');
        Route::patch('/reservasi/{reservation}/status', [\App\Http\Controllers\Admin\ReservationController::class, 'updateStatus'])
            ->name('reservations.update-status');
        Route::delete('/reservasi/{reservation}', [\App\Http\Controllers\Admin\ReservationController::class, 'destroy'])
            ->name('reservations.destroy');

        Route::get('/portofolio', [\App\Http\Controllers\Admin\PortfolioController::class, 'index'])
            ->name('portfolio');
        Route::post('/portofolio', [\App\Http\Controllers\Admin\PortfolioController::class, 'store'])
            ->name('portfolio.store');
        Route::put('/portofolio/{inspiration}', [\App\Http\Controllers\Admin\PortfolioController::class, 'update'])
            ->name('portfolio.update');
        Route::delete('/portofolio/{inspiration}', [\App\Http\Controllers\Admin\PortfolioController::class, 'destroy'])
            ->name('portfolio.destroy');
        Route::patch('/portofolio/{inspiration}/toggle-featured', [\App\Http\Controllers\Admin\PortfolioController::class, 'toggleFeatured'])
            ->name('portfolio.toggle-featured');

        Route::get('/pengguna', [\App\Http\Controllers\Admin\UserController::class, 'index'])
            ->name('users');
        Route::post('/pengguna', [\App\Http\Controllers\Admin\UserController::class, 'store'])
            ->name('users.store');
        Route::put('/pengguna/{user}', [\App\Http\Controllers\Admin\UserController::class, 'update'])
            ->name('users.update');
        Route::delete('/pengguna/{user}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])
            ->name('users.destroy');
        Route::patch('/pengguna/{user}/toggle-status', [\App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])
            ->name('users.toggle-status');

    });


// ==========================================
// DASHBOARD KEUANGAN
// ==========================================

Route::middleware(['auth', 'role:keuangan'])
    ->prefix('keuangan')
    ->name('keuangan.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('keuangan.dashboard');
        })->name('dashboard');

    });
