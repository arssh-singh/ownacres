<?php
use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;

// Dashboard
Route::get('/blogs', [BlogController::class, 'index'])
    ->name('blog.index');

// Create a new draft
Route::post('/blogs/create', [BlogController::class, 'store'])
        ->name('blog.store');

// Editor
Route::get('/blogs/{blog}/edit', [BlogController::class, 'edit'])
        ->name('blog.edit');

// Autosave / Update
Route::patch('/blogs/update/{blog}', [BlogController::class, 'update'])
    ->name('blog.update');

// Blog status
Route::patch('/blogs/{blog}', [BlogController::class, 'status'])->name('blog.status');

// Delete Blog
Route::delete('/blogs/{blog}', [BlogController::class, 'destroy'])->name('blog.destroy');

// Upload Content Images
Route::post('/blogs/{blog}/content-image', [BlogController::class, 'uploadContentImage']
    )->name('blog.content-image');
Route::get('/blog/image/upload', [])->name('blog.image.upload');