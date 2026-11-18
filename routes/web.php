
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\CustomerController;

// HALAMAN UTAMA
Route::get('/', function () {
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    return match (auth()->user()->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'keuangan' => redirect()->route('keuangan.dashboard'),
        'customer' => redirect()->route('customer.dashboard'),
        default => redirect()->route('login'),
    };
});


// LOGIN DAN REGISTER
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.post');

    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register'])
        ->name('register.post');
});


// LOGOUT
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ADMIN
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->group(function () {

        Route::get('/dashboard', [AdminController::class, 'index'])
            ->name('admin.dashboard');

        // KATEGORI
        Route::get('/categories', [AdminController::class, 'categories'])
            ->name('admin.categories');

        Route::post('/categories', [AdminController::class, 'storeCategory'])
            ->name('admin.categories.store');

        Route::put('/categories/{category}', [AdminController::class, 'updateCategory'])
            ->name('admin.categories.update');

        Route::delete('/categories/{category}', [AdminController::class, 'destroyCategory'])
            ->name('admin.categories.destroy');

        // PRODUK
        Route::get('/products', [AdminController::class, 'products'])
            ->name('admin.products');

        Route::post('/products', [AdminController::class, 'storeProduct'])
            ->name('admin.products.store');

        Route::put('/products/{product}', [AdminController::class, 'updateProduct'])
            ->name('admin.products.update');

        Route::delete('/products/{product}', [AdminController::class, 'destroyProduct'])
            ->name('admin.products.destroy');

        // MANAJEMEN PESANAN
        Route::get('/orders', [AdminOrderController::class, 'index'])
            ->name('admin.orders');

        Route::put('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])
            ->name('admin.orders.status');
    });

// KEUANGAN
Route::middleware(['auth', 'role:keuangan'])
    ->prefix('keuangan')
    ->group(function () {

        Route::get('/dashboard', [FinanceController::class, 'index'])
            ->name('keuangan.dashboard');

        Route::post('/transactions', [FinanceController::class, 'store'])
            ->name('keuangan.transactions.store');

        Route::delete('/transactions/{transaction}', [FinanceController::class, 'destroy'])
            ->name('keuangan.transactions.destroy');
    });

// CUSTOMER
Route::middleware(['auth', 'role:customer'])
    ->prefix('customer')
    ->group(function () {

        Route::get('/dashboard', [CustomerController::class, 'index'])
            ->name('customer.dashboard');

        Route::post('/checkout', [CustomerController::class, 'checkout'])
            ->name('customer.checkout');

        Route::get('/orders', [CustomerController::class, 'orders'])
            ->name('customer.orders');
    });
