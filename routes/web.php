<?php

use App\Http\Controllers\PropertyController;
use App\Models\Inquiry;
use Illuminate\Support\Facades\Route;


Route::get('/', [PropertyController:: class, 'index'])->name('home');
Route::get('/marketplace', [PropertyController:: class, 'marketplace'])->name('marketplace');
Route::post('/marketplace/search', [PropertyController::class, 'marketplace_search'])->name('marketplace.properties.search');
Route::get('/properties/{prop_id}/prop_details', [PropertyController::class, 'prop_details'])->name('properties.prop_details');

// user authentication routes
require __DIR__.'/user.php';
require __DIR__.'/authenticated/dashboard.php';
require __DIR__.'/authenticated/properties.php';

Route::middleware('auth')->group(function (){
    Route::view('/dasboard/messages/', 'auth.dashboard.messages.messages')->name('dashboard.messages');

});




