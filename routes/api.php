<?php

use App\Http\Controllers\Api\DaerahController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\PriceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MitraController;

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
Route::prefix('mitra')->group(function (){
    Route::get('/getGuru', [MitraController::class, 'getGuru']);
    Route::get('/detailGuru/{id}', [MitraController::class, 'detailGuru']);
    Route::post('/regisMitra', [MitraController::class, 'regisMitra']);
});
Route::prefix('event')->group(function (){
    Route::get('/getEvent', [EventController::class, 'getEvent']);
    Route::get('/detailEvent/{id}', [EventController::class, 'detailEvent']);
});
Route::prefix('price')->group(function (){
    Route::post('/getPrice', [PriceController::class, 'getPrice']);
});
Route::prefix('daerah')->group(function (){
    Route::get('/getProvinsi', [DaerahController::class, 'getProvinsi']);
    Route::get('/getKota/{id}', [DaerahController::class, 'getKota']);
    Route::get('/getKecamatan/{id}', [DaerahController::class, 'getKecamatan']);
    Route::get('/getKelurahan/{id}', [DaerahController::class, 'getKelurahan']);
});


Route::get('/test', [AuthController::class, 'updateProfil']);
