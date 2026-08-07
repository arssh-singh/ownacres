<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/blog/create', function (){
    return view('auth.dashboard.blog.create');
})->name('blog.create');
Route::post('/blog/create', function (Request $request){
    return $request;
})->name('blog.create');
Route::get('/blog/image/upload', [])->name('blog.image.upload');