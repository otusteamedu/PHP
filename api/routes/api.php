<?php

use App\Http\Controllers\Api\V1\Users\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//Route::get('/v1/users', [UserController::class, 'list']);
Route::group([
    'prefix' => 'v1',
], function() {
    Route::get('/users', [UserController::class, 'list']); // users list
    Route::get('/users/{user}', [UserController::class, 'show']); // user Info
    Route::post('/users', [UserController::class, 'store']); // create user
    Route::put('/users/{user}', [UserController::class, 'update']); // update user
    Route::delete('/users/{user}', [UserController::class, 'destroy']); // delete user
    Route::get('/users/{user}/estate', [UserController::class, 'getEstate']); // estate list
});
