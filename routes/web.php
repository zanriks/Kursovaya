<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/catalog', function () {
    return view('catalog');
});

Route::get('/catalog/instrument', function () {
    return view('catalog_instrument');
});

Route::get('/product_card', function () {
    return view('product_card');
});

Route::get('/cart', function () {
    return view('cart');
});

Route::get('/favorites', function () {
    return view('izbrannoe');
});

Route::get('/profile', function () {
    return view('profile');
});

Route::get('/registration', function () {
    return view('registration');
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
