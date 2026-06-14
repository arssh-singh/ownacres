<?php
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\SavedPropertyController;
use Illuminate\Support\Facades\Route;
// properties
Route::middleware('auth')->group(function () {
    Route::get('/properties/create', function () { return view('auth.dashboard.properties.create');})->name('create-prop');
    Route::post('/properties', [PropertyController::class, 'store'])->name('properties.store');
    Route::get('/properties/{prop_id}/edit', [PropertyController::class, 'get_prop'])->name('properties.edit');
    Route::put('/properties/{prop_id}', [PropertyController::class, 'update'])->name('properties.update');
    Route::delete('/properties/{prop_id}/delete', [PropertyController::class, 'delete'])->name('properties.delete');
    Route::post('/properties/{property}/save', [SavedPropertyController::class, 'toggle'])->name('properties.save');
});
?>