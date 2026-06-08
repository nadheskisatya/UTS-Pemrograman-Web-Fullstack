<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\TransaksiController;

// Landing
Route::get('/', fn() => view('landing'))->name('landing');

// Login langsung (tanpa auth)
Route::get('/kasir', [KasirController::class, 'index'])->name('kasir.index');
Route::post('/kasir/checkout', [KasirController::class, 'checkout'])->name('kasir.checkout');
Route::get('/kasir/logout', fn() => redirect('/'))->name('kasir.logout');



// Admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/logout', fn() => redirect('/'))->name('logout');

    // Orders (Transaksi)
    Route::get('/orders', [TransaksiController::class, 'index'])->name('orders.index');
    Route::delete('/orders/{id}', [TransaksiController::class, 'destroy'])->name('orders.destroy');

    // Produk
    Route::resource('produk', ProdukController::class)->parameters(['produk' => 'id']);

    // Kategori
    Route::resource('kategori', KategoriController::class)->parameters(['kategori' => 'id']);
});
