<?php

use App\Http\Controllers\MarketplaceController;
use App\Http\Controllers\PropertyController;
use App\Models\Inquiry;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

Route::get('/', [PropertyController:: class, 'index'])->name('home');
Route::get('/marketplace', [MarketplaceController:: class, 'marketplace'])->name('marketplace');
Route::match(['get', 'post'], '/marketplace/search', [MarketplaceController::class, 'marketplace_search'])->name('marketplace.properties.search');
Route::match(['get', 'post'], '/marketplace/search/Query', [MarketplaceController::class, 'marketplace_search_by_query'])->name('marketplace.properties.searchByQ');
Route::get('/properties/{prop_id}/prop_details', [PropertyController::class, 'prop_details'])->name('properties.prop_details');

Route::view('/TermsAndConditions', 'terms.termsandconditions')->name('terms');

// user authentication routes
require __DIR__.'/user.php';
require __DIR__.'/dealers.php';
require __DIR__.'/search.php';
require __DIR__.'/blogs.php';
require __DIR__.'/authenticated/dashboard.php';
require __DIR__.'/authenticated/properties.php';

Route::middleware('auth')->group(function (){
    Route::view('/dasboard/messages/', 'auth.dashboard.messages.messages')->name('dashboard.messages');

});

Route::get('/test-mail', function () {
    try {
        Mail::raw('SMTP is working!', function ($message) {
            $message->to('yourpersonal@gmail.com')
                    ->subject('OwnAcres SMTP Test');
        });

        return 'Email sent successfully!';
    } catch (\Exception $e) {
        return $e->getMessage();
    }
});
