<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TenantController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'index'])->name('home');
Route::post('/', [AuthController::class, 'login'])->name('auth.login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['middleware' => 'kasir'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::group(['prefix'=>'inventory'], function(){
        Route::get('/', [InventoryController::class, 'index'])->name('inventory');
        Route::post('/', [InventoryController::class, 'insert'])->name('inventory.add');
        Route::delete('/', [InventoryController::class, 'delete'])->name('inventory.delete');
        Route::put('/', [InventoryController::class, 'update'])->name('inventory.update');
        Route::get('/get-menu-by-tenant/{idTenant?}', [InventoryController::class, 'getMenu'])->name('inventory.menu');
    });
    
    Route::group(['prefix'=>'tenant'], function(){
        Route::get('/', [TenantController::class, 'index'])->name('tenant');
        Route::post('/', [TenantController::class, 'insert'])->name('tenant.add');
        Route::delete('/', [TenantController::class, 'delete'])->name('tenant.delete');
        Route::put('/', [TenantController::class, 'update'])->name('tenant.update');
    });
    
    Route::group(['prefix'=>'kasir'], function(){
        Route::get('/', [KasirController::class, 'index'])->name('kasir');
        Route::post('/', [KasirController::class, 'insert'])->name('kasir.add');
        Route::delete('/', [KasirController::class, 'delete'])->name('kasir.delete');
        Route::put('/', [KasirController::class, 'update'])->name('kasir.update');
    });

    Route::group(['prefix'=>'orders'], function(){
        Route::get('/', [OrderController::class, 'index'])->name('order');
        Route::get('/add', [OrderController::class, 'add'])->name('order.add');
        Route::post('/add', [OrderController::class, 'insert'])->name('order.insert');
        Route::get('/{id?}', [OrderController::class, 'detail'])->name('order');
    });
});