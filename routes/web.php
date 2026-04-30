<?php

use App\Models\Property;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PropertyController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return view('index');
})->name('home');
Route::get('/marketplace', function () {
    return view('marketplace');
})->name('marketplace');

// user auth system
Route::get('/register', [UserController:: class, 'showRegister'])->name('register');
Route::post('/register', [UserController::class, 'store']);

Route::get('/login', [UserController:: class, 'showLogin'])->name('login');
Route::post('/login', [UserController::class, 'login']);


Route::get('/dashboard', function () {
    $properties = Property::where('user_id', Auth::id())
        ->latest()
        ->get();
    return view('dashboard', compact('properties'));
})->name('dashboard')->middleware('auth');

Route::get('/dashboard/properties', function () {
    $properties = Property::where('user_id', Auth::id())
        ->latest()
        ->get();
    return view('properties.show_props', compact('properties'));
})->name('dashboard.properties')->middleware('auth');

Route::post('/logout', function () {
    Auth::logout();
    return redirect(route('home'));
})->name('logout');


// properties
Route::middleware('auth')->group(function () {

    Route::get('/properties/create', function () {
        return view('properties.create');
    })->name('create-prop');

    Route::post('/properties', [PropertyController::class, 'store'])->name('properties.store');
    Route::delete('/properties/{id}', [PropertyController::class, 'destroy']);
});

// Route::get('/properties', [PropertyController::class, 'index']);
// Route::get('/properties/{id}', [PropertyController::class, 'show']);