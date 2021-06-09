<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Reports\BankStatementController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('reports')->name('reports.')->group(function () {
    Route::get('/bank-statement/generate', [BankStatementController:: class, 'generate'])->name('bank-statement.generate');
    Route::get('/bank-statement/status', [BankStatementController::class, 'status'])->name('bank-statement.status');
        // another routes
    });
