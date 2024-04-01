<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VoitureController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::get('/' , [VoitureController::class, 'index']);
// Route::get('/show/{voiture}' , [VoitureController::class, 'show']);

Route::resource('voitures', VoitureController::class);

Route::get('/users', [UserController::class, 'index']);
Route::post('/users', [UserController::class, 'store']);
Route::put('/users/{id}', [UserController::class, 'update']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);

# - Authentication :
Route::post('/login', [AuthController::class, 'login']);

Route::get('/cars/search', [VoitureController::class, 'search']);
Route::post('/cars/estimate', [VoitureController::class, 'estimatePrice']);