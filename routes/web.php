<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PembeliController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman Utama: Redirect sesuai status autentikasi & role
Route::get('/', function () {
    if (Auth::check()) {
        return Auth::user()->isAdmin()
            ? redirect()->route('admin.dashboard')
            : redirect()->route('pembeli.shop');
    }
    return redirect()->route('login');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ==========================================
// RUTE KHUSUS ADMIN
// ==========================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    // Dashboard Admin
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Manajemen Transaksi (Admin)
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
    Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('/transactions/{id}', [TransactionController::class, 'show'])->name('transactions.show');
    Route::delete('/transactions/{id}', [TransactionController::class, 'destroy'])->name('transactions.destroy');
});

// Admin juga mengelola Produk & Supplier (bisa tetap menggunakan URL lama agar kompatibel)
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Data Produk
    Route::get('/products', [ProductController::class, 'index'])->name('product.index');
    Route::get('/product-create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/products-store', [ProductController::class, 'store'])->name('product.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('product.destroy');

    // Data Supplier
    Route::get('/suppliers', [SupplierController::class, 'index'])->name('supplier.index');
    Route::get('/supplier-create', [SupplierController::class, 'create'])->name('supplier.create');
    Route::post('/supplier-store', [SupplierController::class, 'store'])->name('supplier.store');
    Route::get('/suppliers/{supplier}/edit', [SupplierController::class, 'edit'])->name('supplier.edit');
    Route::put('/suppliers/{supplier}', [SupplierController::class, 'update'])->name('supplier.update');
    Route::delete('/suppliers/{supplier}', [SupplierController::class, 'destroy'])->name('supplier.destroy');
});

// ==========================================
// RUTE KHUSUS PEMBELI
// ==========================================
Route::middleware(['auth', 'role:pembeli'])->prefix('pembeli')->group(function () {
    // Halaman Belanja Produk
    Route::get('/', [PembeliController::class, 'shop'])->name('pembeli.shop');
    Route::get('/shop', [PembeliController::class, 'shop']);

    // Proses Checkout Transaksi & Detail
    Route::post('/checkout', [PembeliController::class, 'checkout'])->name('pembeli.checkout');

    // Riwayat Transaksi & Nota / Invoice
    Route::get('/transaksi', [PembeliController::class, 'history'])->name('pembeli.transactions');
    Route::get('/transaksi/{id}', [PembeliController::class, 'detail'])->name('pembeli.transaction.detail');
});
