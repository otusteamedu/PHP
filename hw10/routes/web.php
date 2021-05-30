<?php

use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\Route;

Route::get('/', [StoreController::class, 'index'])->name('index');
Route::post('/store', [StoreController::class, 'store'])->name('store');
Route::get('/get', [StoreController::class, 'get'])->name('get');
Route::get('/flush', [StoreController::class, 'flush'])->name('flush');
