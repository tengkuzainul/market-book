<?php

use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Customer\KeranjangController;
use App\Http\Controllers\Customer\OrderController;
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

// Customer Routes (requires authentication)
Route::middleware('auth')->prefix('customer')->name('customer.')->group(function () {
    // Cart Routes
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('cart.index');
    Route::post('/keranjang', [KeranjangController::class, 'store'])->name('cart.store');
    Route::put('/keranjang/{id}', [KeranjangController::class, 'update'])->name('cart.update');
    Route::delete('/keranjang/{id}', [KeranjangController::class, 'destroy'])->name('cart.destroy');
    Route::get('/checkout', [KeranjangController::class, 'checkout'])->name('checkout');

    // Order Routes
    Route::get('/pesanan', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/pesanan', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/pesanan/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/pesanan/{id}/upload-bukti', [OrderController::class, 'uploadBuktiPembayaran'])->name('orders.upload');
    Route::post('/pesanan/{id}/batal', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::post('/pesanan/{id}/selesai', [OrderController::class, 'complete'])->name('orders.complete');
});

// Customer refund routes
Route::middleware('auth')->name('refunds.')->group(function () {
    Route::get('/refunds', [\App\Http\Controllers\RefundController::class, 'index'])->name('index');
    Route::get('/refunds/{refund}', [\App\Http\Controllers\RefundController::class, 'show'])->name('show');
    Route::get('/pesanan/{pesanan}/refund', [\App\Http\Controllers\RefundController::class, 'create'])->name('create');
    Route::post('/pesanan/{pesanan}/refund', [\App\Http\Controllers\RefundController::class, 'store'])->name('store');
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

    // Admin Orders Management
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{id}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::put('/orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');

        // Refund Management
        Route::get('/refunds', [\App\Http\Controllers\Admin\RefundController::class, 'index'])->name('refunds.index');
        Route::get('/refunds/{refund}', [\App\Http\Controllers\Admin\RefundController::class, 'show'])->name('refunds.show');
        Route::post('/refunds/{refund}/process', [\App\Http\Controllers\Admin\RefundController::class, 'process'])->name('refunds.process');
        Route::post('/refunds/{refund}/upload-proof', [\App\Http\Controllers\Admin\RefundController::class, 'uploadProof'])->name('refunds.upload-proof');
    });
});

require __DIR__ . '/auth.php';
