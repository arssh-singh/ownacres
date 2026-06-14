<?php

use App\Models\Property;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\SavedPropertyController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::get('/', [PropertyController:: class, 'index'])->name('home');
Route::get('/marketplace', [PropertyController:: class, 'marketplace'])->name('marketplace');
Route::get('/marketplace/search', [PropertyController::class, 'marketplace_search'])->name('marketplace.properties.search');

// user auth system
Route::get('/newuser', [UserController:: class, 'putinregister'])->name('newuser');
Route::get('/register', [UserController:: class, 'showRegister'])->name('register');
Route::post('/register', [UserController::class, 'sendOTP'])->name('register.sendOTP');
Route::get('/verifyOTP', [UserController::class, 'verifyOTPForm'])->name('register.verifyOTP.form');
Route::post('/verifyOTP', [UserController::class, 'verifyOTP'])->name('register.verifyOTP');

Route::get('/forgot-password/form', [UserController::class, 'forgot_password_form'])->name('forgotpass.form');
Route::post('/forgot-password/sendOTP', [UserController::class, 'forgot_password_sendOTP'])->name('forgotpass.sendOTP');

Route::get('/forgot-password/verifyOTP/form', [UserController::class, 'forgot_password_verifyOTP_form'])->name('forgotpass.verifyOTP.form');
Route::post('/forgot-password/verifyOTP', [UserController::class, 'verifyForgotPassOTP'])->name('forgotpass.verifyOTP');

Route::get('/forgot-password/new-password-form', [UserController::class, 'forgotpassnewpassform'])->name('forgotpass.newpass.form');
Route::post('/forgot-password/change-password', [UserController::class, 'forgotpasschangepass'])->name('forgotpass.changepass');



Route::get('/login', [UserController:: class, 'showLogin'])->name('login');
Route::post('/login', [UserController::class, 'login']);


Route::get('/dashboard', function () {
    $savedProperties = auth()->user()->savedProperties()->latest()->take(5)->get();
    $savedCount = auth()->user()->savedProperties()->count();
    return view('auth.dashboard.dashboard', compact('savedProperties', 'savedCount'));
})->name('dashboard')->middleware('auth');

// profile
Route::middleware('auth')->group(function () {
    // dashboard profile
    Route::get('/dashboard/profile', function () {
        return view('auth.dashboard.profile.profile');
    })->name('dashboard.profile');
    Route::post('/dashboard/profile/image/update', [UserController::class, 'updateProfileImage'])->name('dashboard.profile.image.update');
});


Route::get('/dashboard/properties', function () {
    $properties = Property::where('user_id', Auth::id())
        ->latest()
        ->get();
    return view('auth.dashboard.properties.show_props', compact('properties'));
})->name('dashboard.properties')->middleware('auth');

Route::post('/logout', function () {
    Auth::logout();
    return redirect(route('home'));
})->name('logout');

Route::get('/properties/{prop_id}/prop_details', [PropertyController::class, 'prop_details'])->name('properties.prop_details');

// properties
Route::middleware('auth')->group(function () {
    Route::get('/properties/create', function () { return view('auth.dashboard.properties.create');})->name('create-prop');
    Route::post('/properties', [PropertyController::class, 'store'])->name('properties.store');
    Route::get('/properties/{prop_id}/edit', [PropertyController::class, 'get_prop'])->name('properties.edit');
    Route::put('/properties/{prop_id}', [PropertyController::class, 'update'])->name('properties.update');
    Route::delete('/properties/{prop_id}/delete', [PropertyController::class, 'delete'])->name('properties.delete');

});

Route::post('/properties/{property}/save', [SavedPropertyController::class, 'toggle'])
    ->name('properties.save')
    ->middleware('auth');