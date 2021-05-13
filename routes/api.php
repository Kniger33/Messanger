<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Чат
Route::get('/v1/{userId}/chats', [\App\Http\Controllers\ChatController::class, 'index']);
Route::post('/v1/{userId}/chats', [\App\Http\Controllers\ChatController::class, 'store'])
    ->middleware('isAdmin');
Route::get('/v1/{userId}/chats/{chatId}', [\App\Http\Controllers\ChatController::class, 'show']);
Route::put('/v1/{userId}/chats/{chatId}', [\App\Http\Controllers\ChatController::class, 'update'])
    ->middleware('isAdmin');
Route::delete('/v1/{userId}/chats/{chatId}', [\App\Http\Controllers\ChatController::class, 'destroy'])
    ->middleware('isAdmin');

