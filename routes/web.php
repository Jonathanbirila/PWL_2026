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

Route::get('/products', [ProductController::class, 'index']);
Route::get('/product-create', [ProductController::class, 'create']);
Route::post('/products', [ProductController::class, 'store']);
Route::get('/product/{id}', [ProductController::class, 'edit']);
Route::get('/product-detail/{id}', [ProductController::class, 'show']);
Route::put('/product/{id}', [ProductController::class, 'update']);
Route::delete('/product/{id}', [ProductController::class, 'destroy']);

Route::get('/suppliers', [SupplierController::class, 'index']);
Route::get('/supplier-create', [SupplierController::class, 'create']);
Route::post('/suppliers', [SupplierController::class, 'store']);
Route::get('/supplier/{id}', [SupplierController::class, 'edit']);
Route::get('/supplier-detail/{id}', [SupplierController::class, 'show']);
Route::put('/supplier/{id}', [SupplierController::class, 'update']);
Route::delete('/supplier/{id}', [SupplierController::class, 'destroy']);

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

