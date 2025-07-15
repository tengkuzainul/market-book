<?php

use App\Http\Controllers\FrontendController;
use App\Http\Controllers\MasterData\BukuController;
use App\Http\Controllers\MasterData\KategoriBukuController;
use App\Http\Controllers\MasterData\PenggunaController;
use App\Http\Controllers\MasterData\RekeningController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::controller(FrontendController::class)->group(function () {
    Route::get('/', 'home')->name('frontend.home');
    Route::get('/produk', 'products')->name('frontend.products');
    Route::get('/kategori/{slug}', 'category')->name('frontend.category');
    Route::get('/produk/{slug}', 'productDetail')->name('frontend.product.detail');
    Route::get('/hubungi-kami', 'contact')->name('frontend.contact');
});

Route::get('/dashboard', function () {
    return view('dashboard', [
        'pageName' => 'Dashboard',
        'currentPage' => 'Home',
    ]);
})->middleware(['auth', 'verified', 'admin'])->name('dashboard');

Route::middleware('auth', 'admin')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile-password', [ProfileController::class, 'editPassword'])->name('profile.password');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile-password', [ProfileController::class, 'updatePassword'])->name('profile.update.password');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('master-data')->group(function () {
        Route::resource('pengguna', PenggunaController::class);
        Route::resource('kategori-buku', KategoriBukuController::class);
        Route::resource('buku', BukuController::class);
        Route::resource('rekening', RekeningController::class);
    });
});

require __DIR__ . '/auth.php';
