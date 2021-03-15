<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

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
Route::prefix('user')->group(function (){
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);

    Route::group(['middleware' => 'auth:sanctum'], function (){
        Route::post('/updateProfil', [AuthController::class, 'updateProfil']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/detailUser', [AuthController::class, 'detailUser']);
    });
});


Route::get('/test', [AuthController::class, 'updateProfil']);
