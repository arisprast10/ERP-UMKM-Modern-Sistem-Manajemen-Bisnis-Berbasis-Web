<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('customers', \App\Http\Controllers\CustomerController::class);
    
    // Role: Admin, Gudang
    Route::middleware('role:admin,gudang')->group(function () {
        Route::resource('products', \App\Http\Controllers\ProductController::class);
        Route::resource('categories', \App\Http\Controllers\CategoryController::class);
        Route::resource('suppliers', \App\Http\Controllers\SupplierController::class);
    });

    // Role: Admin
    Route::middleware('role:admin')->group(function () {
        Route::resource('expense_categories', \App\Http\Controllers\ExpenseCategoryController::class);
        Route::resource('expenses', \App\Http\Controllers\ExpenseController::class);
        Route::resource('users', \App\Http\Controllers\UserController::class);
    });
    
    // Role: Admin, Gudang
    Route::middleware('role:admin,gudang')->group(function () {
        Route::get('stock', [\App\Http\Controllers\StockController::class, 'index'])->name('stock.index');
        Route::get('stock/in', [\App\Http\Controllers\StockController::class, 'createIn'])->name('stock.in');
        Route::post('stock/in', [\App\Http\Controllers\StockController::class, 'storeIn'])->name('stock.storeIn');
        Route::get('stock/out', [\App\Http\Controllers\StockController::class, 'createOut'])->name('stock.out');
        Route::post('stock/out', [\App\Http\Controllers\StockController::class, 'storeOut'])->name('stock.storeOut');
    });
    
    // Role: Admin, Kasir
    Route::middleware('role:admin,kasir')->group(function () {
        Route::get('pos', [\App\Http\Controllers\PosController::class, 'index'])->name('pos.index');
        Route::get('pos/search', [\App\Http\Controllers\PosController::class, 'search'])->name('pos.search');
        Route::post('pos/store', [\App\Http\Controllers\PosController::class, 'store'])->name('pos.store');
        Route::get('pos/invoice/{transaction}', [\App\Http\Controllers\PosController::class, 'invoice'])->name('pos.invoice');
    });
    
    // Role: Admin
    Route::middleware('role:admin')->group(function () {
        Route::resource('transactions', \App\Http\Controllers\TransactionController::class)->only(['index', 'show']);
        Route::get('reports', [\App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
    });
    
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile');
    Route::put('profile', [ProfileController::class, 'update']);
    Route::put('profile/password', [ProfileController::class, 'updatePassword']);

    // Settings - Admin only
    Route::middleware('role:admin')->group(function () {
        Route::get('settings', [\App\Http\Controllers\StoreSettingController::class, 'index'])->name('settings.index');
        Route::put('settings', [\App\Http\Controllers\StoreSettingController::class, 'update'])->name('settings.update');
    });
});
