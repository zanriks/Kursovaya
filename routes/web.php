<?php

use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);

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

Route::put('/profile', [AuthController::class, 'updateProfile'])
    ->middleware('auth')
    ->name('profile.update');

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::redirect('/', '/admin/products')->name('dashboard');

        Route::resource('products', AdminProductController::class)
            ->except(['show']);
    });

Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog');
Route::get('/catalog/{slug}', [CatalogController::class, 'show'])->name('catalog.show');

Route::get('/search', [CatalogController::class, 'search'])->name('search');

Route::get('/product/{slug}', [ProductController::class, 'show'])
    ->name('product.show');

Route::post('/product/{slug}/reviews', [ReviewController::class, 'store'])
    ->middleware('auth')
    ->name('reviews.store');
Route::get('/product_card', function () {
    $product = \App\Models\Product::query()
        ->where('is_active', true)
        ->firstOrFail();

    return redirect('/product/' . $product->slug);
});
Route::get('/cart', [CartController::class, 'index'])
    ->name('cart.index');

Route::post('/cart/add/{slug}', [CartController::class, 'add'])
    ->middleware('auth')
    ->name('cart.add');

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
