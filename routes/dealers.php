<?php
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
Route::get('/dealers', function () {
    $dealers = User::whereHas('properties', function ($query) {
                    $query->where('status', 'published')
                        ->whereHas('pricing', function ($q) {
                            $q->whereIn('listing_type', ['sale', 'rent']);
                        });
                })->get();

    return view('dealers.index', compact('dealers'));
})->name('dealers');
Route::get('dealer/profile/{id}', function ($id) {
    $dealer = User::with([
        'properties.coverImage',
        'properties.pricing',
        'properties.basics'
    ])->findOrFail($id);

    return view('dealers.profile', compact('dealer'));
})->name('dealer.profile');
Route::post('dealer/profile/edit', function (Request $request) {

    $validated = $request->validate([
        'headline' => ['nullable', 'string', 'max:100'],
        'bio'      => ['nullable', 'string', 'max:1000'],
    ]);

    auth()->user()->profile()->update($validated);

    return response()->json([
        'success' => true,
        'message' => 'Profile updated successfully.',
        'profile' => auth()->user()->profile,
    ]);
})->middleware('auth')->name('dashboard.editHeadlineBio');