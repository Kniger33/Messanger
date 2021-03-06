<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\OtherFunctionalityController;
use App\Http\Controllers\UserController;

use App\Http\Middleware\EnsureChatExists;
use App\Http\Middleware\EnsureDocumentExists;
use App\Http\Middleware\EnsureUserExists;

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

Route::middleware(EnsureUserExists::class)->group(function (){

    // Запрос на создание чата
    Route::post('/v1/{userId}/requestToCreateChat', [OtherFunctionalityController::class, 'requestToAdmin']);

    // Чат
    Route::get('/v1/{userId}/chats', [ChatController::class, 'index']);
    Route::post('/v1/{userId}/chats', [ChatController::class, 'store'])
        ->middleware('isAdmin');

    Route::middleware(EnsureChatExists::class)->group(function (){
        // Чат
        Route::get('/v1/{userId}/chats/{chatId}', [ChatController::class, 'show']);
        Route::put('/v1/{userId}/chats/{chatId}', [ChatController::class, 'update'])
            ->middleware('isAdmin');
        Route::delete('/v1/{userId}/chats/{chatId}', [ChatController::class, 'destroy'])
            ->middleware('isAdmin');
        Route::get('/v1/{userId}/chats/{chatId}/haveNewMessages', [ChatController::class, 'haveNewMessages']);

        // Сообщения
        Route::get('/v1/{userId}/chats/{chatId}/messages', [MessageController::class, 'index']);
        Route::post('/v1/{userId}/chats/{chatId}/messages', [MessageController::class, 'store']);
        Route::get('/v1/{userId}/chats/{chatId}/messages/{messageId}', [MessageController::class, 'show'])
            ->middleware('messageExists');
        Route::put('/v1/{userId}/chats/{chatId}/messages/{messageId}', [MessageController::class, 'update'])
            ->middleware('messageExists');
        Route::delete('/v1/{userId}/chats/{chatId}/messages/{messageId}', [MessageController::class, 'destroy'])
            ->middleware('messageExists');

        // Пользователь
        Route::get('v1/{userId}/chats/{chatId}/users', [UserController::class, 'index']);
        Route::post('v1/{userId}/chats/{chatId}/users', [UserController::class, 'store'])
            ->middleware('isAdmin');
        Route::get('v1/{userId}/chats/{chatId}/users/{userInChatId}', [UserController::class, 'show']);
        Route::put('v1/{userId}/chats/{chatId}/users/{userInChatId}', [UserController::class, 'update'])
            ->middleware('isAdmin');
        Route::delete('v1/{userId}/chats/{chatId}/users/{userInChatId}', [UserController::class, 'destroy'])
            ->middleware('isAdmin');

        // Документы
        Route::get('v1/{userId}/chats/{chatId}/documents', [DocumentController::class, 'index']);
        Route::post('v1/{userId}/chats/{chatId}/documents', [DocumentController::class, 'store']);
        Route::get('v1/{userId}/chats/{chatId}/userDocuments', [DocumentController::class, 'userDocuments']);
        Route::middleware(EnsureDocumentExists::class)->group(function (){
            Route::get('v1/{userId}/chats/{chatId}/documents/{documentId}', [DocumentController::class, 'show']);
            Route::put('v1/{userId}/chats/{chatId}/documents/{documentId}', [DocumentController::class, 'update']);
            Route::delete('v1/{userId}/chats/{chatId}/documents/{documentId}', [DocumentController::class, 'destroy']);
            Route::get('v1/{userId}/chats/{chatId}/documents/{documentId}/data', [DocumentController::class, 'getData']);
            Route::post('v1/{userId}/chats/{chatId}/documents/{documentId}/data', [DocumentController::class, 'setData']);
        });
    });

});


