<?php

use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);

Route::get('/catalog', [CatalogController::class, 'index']);
Route::get('/catalog/{slug}', [CatalogController::class, 'show']);

Route::get('/product/{slug}', [ProductController::class, 'show']);
Route::get('/product_card', function () {
    $product = \App\Models\Product::query()
        ->where('is_active', true)
        ->firstOrFail();

    return redirect('/product/' . $product->slug);
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');

    Route::get('/registration', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/registration', [AuthController::class, 'register'])->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::get('/profile', [AuthController::class, 'profile'])
    ->middleware('auth')
    ->name('profile');

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::redirect('/', '/admin/products')->name('dashboard');

        Route::resource('products', AdminProductController::class)
            ->except(['show']);
    });

Route::get('/cart', function () {
    return view('cart');
});

Route::get('/favorites', function () {
    return view('izbrannoe');
});

Route::get('/contacts', function () {
    return view('contacts');
});

Route::get('/services', function () {
    return view('services');
});

Route::get('/about', function () {
    return view('about');
});