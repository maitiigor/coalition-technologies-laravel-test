<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return redirect(route('products.index'));
});


Route::resource('products', App\Http\Controllers\ProductController::class);
