<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;

Route::post('/search', [SearchController::class, 'home'])->name('search.home');
Route::post('/search/home', [SearchController::class, 'search'])->name('search');
Route::post('/search/filter', [SearchController::class, 'filter'])->name('search.filter');