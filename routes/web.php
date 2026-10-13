<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransactionDetailController;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    // return view('welcome');
    return Product::with('Supplier')->get();
});

Route::get('products', [ProductController::class, 'index'])->name('product.index');
Route::get('product-create', [ProductController::class, 'create'])->name('product.create');
Route::post('products-store', [ProductController::class, 'store'])->name('product.store');
Route::get('products/{product}/edit', [ProductController::class, 'edit'])->name('product.edit');
Route::put('products/{product}', [ProductController::class, 'update'])->name('product.update');
Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('product.destroy');

Route::get('suppliers', [SupplierController::class, 'index'])->name('supplier.index');
Route::get('supplier-create', [SupplierController::class, 'create'])->name('supplier.create');
Route::post('supplier-store', [SupplierController::class, 'store'])->name('supplier.store');
Route::get('suppliers/{supplier}/edit', [SupplierController::class, 'edit'])->name('supplier.edit');
Route::put('suppliers/{supplier}', [SupplierController::class, 'update'])->name('supplier.update');
Route::delete('suppliers/{supplier}', [SupplierController::class, 'destroy'])->name('supplier.destroy');

Route::get('/transactions', [TransactionController::class, 'index']);
Route::get('/transaction-create', [TransactionController::class, 'create']);
Route::post('/transactions', [TransactionController::class, 'store']);
Route::get('/transaction/{id}', [TransactionController::class, 'edit']);
Route::get('/transaction-detail/{id}', [TransactionController::class, 'show']);
Route::put('/transaction/{id}', [TransactionController::class, 'update']);
Route::delete('/transaction/{id}', [TransactionController::class, 'destroy']);

Route::get('/transactionDetails', [TransactionDetailController::class, 'index']);
Route::get('/transactionDetail-create', [TransactionDetailController::class, 'create']);
Route::post('/transactionDetails', [TransactionDetailController::class, 'store']);
Route::get('/transactionDetail/{id}', [TransactionDetailController::class, 'edit']);
Route::get('/transactionDetail-detail/{id}', [TransactionDetailController::class, 'show']);
Route::put('/transactionDetail/{id}', [TransactionDetailController::class, 'update']);
Route::delete('/transactionDetail/{id}', [TransactionDetailController::class, 'destroy']);

