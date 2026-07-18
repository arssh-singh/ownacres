<?php

use App\Http\Controllers\MarketplaceController;
use App\Http\Controllers\PropertyController;
use App\Models\Inquiry;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

Route::get('/', [PropertyController:: class, 'index'])->name('home');
Route::get('/marketplace', [MarketplaceController:: class, 'marketplace'])->name('marketplace');
Route::match(['get', 'post'], '/marketplace/search', [MarketplaceController::class, 'marketplace_search'])->name('marketplace.properties.search');
Route::match(['get', 'post'], '/marketplace/search/Query', [MarketplaceController::class, 'marketplace_search_by_query'])->name('marketplace.properties.searchByQ');
Route::get('/properties/{prop_id}/prop_details', [PropertyController::class, 'prop_details'])->name('properties.prop_details');


// user authentication routes
require __DIR__.'/user.php';
require __DIR__.'/authenticated/dashboard.php';
require __DIR__.'/authenticated/properties.php';

Route::middleware('auth')->group(function (){
    Route::view('/dasboard/messages/', 'auth.dashboard.messages.messages')->name('dashboard.messages');

});




