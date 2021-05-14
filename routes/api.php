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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::middleware(\App\Http\Middleware\EnsureUserExists::class)->group(function (){

    // Чат
    Route::get('/v1/{userId}/chats', [\App\Http\Controllers\ChatController::class, 'index'])
        ->middleware(\App\Http\Middleware\EnsureUserExists::class);
    Route::post('/v1/{userId}/chats', [\App\Http\Controllers\ChatController::class, 'store'])
        ->middleware('isAdmin');

    Route::middleware(\App\Http\Middleware\EnsureChatExists::class)->group(function (){
        // Чат
        Route::get('/v1/{userId}/chats/{chatId}', [\App\Http\Controllers\ChatController::class, 'show']);
        Route::put('/v1/{userId}/chats/{chatId}', [\App\Http\Controllers\ChatController::class, 'update'])
            ->middleware('isAdmin');
        Route::delete('/v1/{userId}/chats/{chatId}', [\App\Http\Controllers\ChatController::class, 'destroy'])
            ->middleware('isAdmin');
        Route::get('/v1/{userId}/chats/{chatId}/haveNewMessages', [\App\Http\Controllers\ChatController::class, 'haveNewMessages']);

        // Сообщения
        Route::get('/v1/{userId}/chats/{chatId}/messages', [\App\Http\Controllers\MessageController::class, 'index']);
        Route::post('/v1/{userId}/chats/{chatId}/messages', [\App\Http\Controllers\MessageController::class, 'store']);
        Route::get('/v1/{userId}/chats/{chatId}/messages/{messageId}', [\App\Http\Controllers\MessageController::class, 'show'])
            ->middleware('messageExists');
        Route::put('/v1/{userId}/chats/{chatId}/messages/{messageId}', [\App\Http\Controllers\MessageController::class, 'update'])
            ->middleware('messageExists');
        Route::delete('/v1/{userId}/chats/{chatId}/messages/{messageId}', [\App\Http\Controllers\MessageController::class, 'destroy'])
            ->middleware('messageExists');
    });

});


