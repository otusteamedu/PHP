<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/event', [App\Http\Controllers\EventController::class, 'index'])->name('INDEX');
Route::get('/event/delete/{item}', [App\Http\Controllers\EventController::class, 'delete'])->name('delete');
Route::get('/event/clear', [App\Http\Controllers\EventController::class, 'clear'])->name('clear');
Route::get('/event/create', [App\Http\Controllers\EventController::class, 'create'])->name('create');
Route::get('/event/seedNosql', [App\Http\Controllers\EventController::class, 'seedNosql'])->name('seedNosql');
Route::get('/event/seedMysql', [App\Http\Controllers\EventController::class, 'seedMysql'])->name('seedMysql');
Route::get('/event/showAll', [App\Http\Controllers\EventController::class, 'showAll'])->name('showAll');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
