<?php

use App\Models\Property;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PropertyController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::get('/', [PropertyController:: class, 'index'])->name('home');
Route::get('/marketplace', [PropertyController:: class, 'marketplace'])->name('marketplace');

// user auth system
Route::get('/register', [UserController:: class, 'showRegister'])->name('register');
Route::post('/register', [UserController::class, 'store']);

Route::get('/login', [UserController:: class, 'showLogin'])->name('login');
Route::post('/login', [UserController::class, 'login']);


Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard')->middleware('auth');

Route::get('/dashboard/properties', function () {
    $properties = Property::where('user_id', Auth::id())
        ->latest()
        ->get();
    return view('dashboard_properties.show_props', compact('properties'));
})->name('dashboard.properties')->middleware('auth');

Route::post('/logout', function () {
    Auth::logout();
    return redirect(route('home'));
})->name('logout');

Route::get('/properties/{prop_id}/prop_details', [PropertyController::class, 'prop_details'])->name('properties.prop_details');

// properties
Route::middleware('auth')->group(function () {
    Route::get('/properties/create', function () { return view('dashboard_properties.create');})->name('create-prop');
    Route::post('/properties', [PropertyController::class, 'store'])->name('properties.store');
    Route::get('/properties/{prop_id}/edit', [PropertyController::class, 'get_prop'])->name('properties.edit');
    Route::put('/properties/{prop_id}', [PropertyController::class, 'update'])->name('properties.update');
    Route::delete('/properties/{prop_id}/delete', [PropertyController::class, 'delete'])->name('properties.delete');

});

// Route::get('/properties', [PropertyController::class, 'index']);
// Route::get('/properties/{id}', [PropertyController::class, 'show']);