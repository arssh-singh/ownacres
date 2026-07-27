<?php
use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;

Route::get('/education', [BlogController::class, 'blogs'])->name('blogs');
Route::get('/blogs/full_blog.php', [BlogController::class, 'show'])
    ->name('blogs.show');