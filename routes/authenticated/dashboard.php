<?php
use App\Http\Controllers\UserController;
use App\Models\Property;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $savedProperties = auth()->user()->savedProperties()->latest()->take(5)->get();
        $savedCount = auth()->user()->savedProperties()->count();
        return view('auth.dashboard.home.home', compact('savedProperties', 'savedCount'));
    })->name('dashboard');

    
    // dashboard profile
    Route::get('/dashboard/profile', function () {
        return view('auth.dashboard.profile.profile');
    })->name('dashboard.profile');
    Route::post('/dashboard/profile/image/update', [UserController::class, 'updateProfileImage'])->name('dashboard.profile.image.update');
    // dashbaord properties
    Route::get('/dashboard/properties', function () {
        $properties = Property::where('user_id', Auth::id())
            ->latest()
            ->get();
        return view('auth.dashboard.properties.show_props', compact('properties'));
    })->name('dashboard.properties')->middleware('auth');
    // dashbaord saved properties
    Route::get('/dashboard/saved_properties', function () {
        $properties = auth()->user()->savedProperties()->latest()->get();

        return view('auth.dashboard.saved_properties.saved_properties', compact('properties'));
    })->name('dashboard.savedProperties');
});

