<?php

use App\Http\Controllers\Api\TranslationController;
use App\Http\Controllers\Api\UserController;
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

Route::post('users/register', [UserController::class, 'register']);
Route::post('users/login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('users', [UserController::class, 'index']);
    
    Route::apiResource('translations', TranslationController::class);
    Route::get('translations/lang/{source_language}/{target_language}', [TranslationController::class, 'getByLanguage']);

    Route::get('user', function (Request $request) {
        return $request->user();
    });
});
