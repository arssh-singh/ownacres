<?php
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;    

Route::get('/dashboard/chat', [ChatController::class, 'index'])
    ->name('dashboard.chat');

// creating conversation
Route::post('/dashboard/chat/start/coversation/{prop_id}', [ChatController::class, 'start'])->name('dashboard.chat.start');
Route::get('/dashboard/chat/{conversation}', [ChatController::class, 'conversation'])
    ->name('dashboard.chat.conversation');

Route::post('/dashboard/chat/send', [ChatController::class, 'send'])
    ->name('dashboard.chat.send');
