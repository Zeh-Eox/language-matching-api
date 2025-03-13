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

Route::post('users/register', [UserController::class, "register"]);
Route::post('users/login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function(): void
{
    Route::post('/translations', [TranslationController::class, 'store']);
    Route::get('/translations', [TranslationController::class, 'index']);
    Route::get(
        '/translations/lang/{source_lang}/{target_lang}', 
        [TranslationController::class, 'getByLanguage']
    );

    Route::get('/user', function(Request $request): mixed
    {
        return $request->user();
    });
});
