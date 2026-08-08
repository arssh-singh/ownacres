<?php
use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
Route::get('/education', [BlogController::class, 'blogs'])->name('blogs');
Route::get('/blogs/full_blog.php', [BlogController::class, 'show'])
    ->name('blogs.show');

Route::get('/test', function(){
    return view('test');
});
Route::post('/test-upload', function (Request $request) {
    \Log::info('UPLOAD TEST REACHED', [
        'has_file' => $request->hasFile('image'),
        'file' => $request->file('image')?->getClientOriginalName(),
    ]);

    return response()->json([
        'success' => true,
        'has_file' => $request->hasFile('image'),
    ]);
});