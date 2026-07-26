<?php
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\Property\PropertyMediaController;
use App\Http\Controllers\Property\PropertyBasicsController;
use App\Http\Controllers\Property\PropertyPricingController;
use App\Http\Controllers\Property\PropertyLocationController;
use App\Http\Controllers\SavedPropertyController;
use Illuminate\Support\Facades\Route;
use App\Models\Property;
// properties
Route::middleware('auth')->group(function () {
    Route::get('/properties/create', [PropertyController::class, 'create'])->name('properties.create');
    Route::get('/properties/{property}/get/media', function (Property $property){
        return view('auth.dashboard.properties.get_media', compact('property'));
    })->name('properties.media.get');
    Route::post('/properties/{property}/store/media', [PropertyMediaController::class, 'store'])->name('properties.media.store');
    
    Route::get('/properties/{property}/get/basics', function(Property $property){
        return view('auth.dashboard.properties.get_basics', compact('property'));
    })->name('properties.basics.get');
    Route::post('/properties/{property}/store/basics', [PropertyBasicsController::class, 'store'])->name('properties.basics.store');
    
    Route::get('/properties/{property}/get/pricing', function(Property $property){
        return view('auth.dashboard.properties.get_pricing', compact('property'));
    })->name('properties.pricing.get');
    Route::post('/properties/{property}/store/pricing', [PropertyPricingController::class, 'store'])->name('properties.pricing.store');
    
    Route::get('/properties/{property}/get/location', function(Property $property){
        return view('auth.dashboard.properties.get_location', compact('property'));
    })->name('properties.location.get');
    Route::post('/properties/{property}/store/location', [PropertyLocationController::class, 'store'])->name('properties.location.store');

    Route::patch('/properties/{property}/status', [PropertyController::class, 'updateStatus'])
    ->name('properties.updateStatus');

    Route::post('/properties', [PropertyController::class, 'store'])->name('properties.store');
    Route::get('/properties/{property}/edit', [PropertyController::class, 'edit'])->name('properties.edit');
    Route::put('/properties/{prop_id}', [PropertyController::class, 'update'])->name('properties.update');
    Route::delete('/properties/{prop_id}/delete', [PropertyController::class, 'delete'])->name('properties.delete');
    Route::post('/properties/{property}/save', [SavedPropertyController::class, 'toggle'])->name('properties.save');

    Route::post('/properties/upload/filepond/', [PropertyMediaController::class, 'upload'])->name('property.temp.upload');
    Route::delete('/properties/delete/filepond/', [PropertyMediaController::class, 'delete'])->name('property.temp.delete');
});


?>