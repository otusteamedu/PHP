<?php

use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\Route;

Route::get('/', [StoreController::class, 'index']);
Route::post('/store', [StoreController::class, 'store']);
