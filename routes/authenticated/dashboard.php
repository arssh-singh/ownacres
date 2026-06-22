<?php
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\UserController;
use App\Models\Property;
use App\Models\Inquiry;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $savedProperties = auth()->user()->savedProperties()->latest()->take(5)->get();
        $savedCount = auth()->user()->savedProperties()->count();
        $inquiriesCount = Inquiry::where('receiver_id', auth()->id())->count();
        $mylistedProperties = Property::where('user_id', auth()->id())->count();
        // recent inquiries
        $recentInquiries = Inquiry::where('receiver_id', auth()->id())->latest()->take(5)->get();
        return view('auth.dashboard.home.home', compact('savedProperties', 'savedCount', 'inquiriesCount', 'mylistedProperties', 'recentInquiries'));
    })->name('dashboard');

    
    // dashboard profile
    Route::get('/dashboard/profile', function () {
        return view('auth.dashboard.profile.profile');
    })->name('dashboard.profile');
    Route::post('/dashboard/profile/image/update', [UserController::class, 'updateProfileImage'])->name('dashboard.profile.image.update');
    // dashboard edit profile
    Route::post('/dashboard/edit/profile', [UserController::class, 'sendEditProfileOtp'])->name('dashboard.editProfile');
    Route::post('/dashboard/edit/profile/checkOtp', [UserController::class, 'editProfileOtpCheck'])->name('dashboard.editProfile.checkOtp');




    // dashbaord properties
    Route::get('/dashboard/properties', function () {
        $properties = Property::where('user_id', Auth::id())
            ->latest()
            ->get();
        return view('auth.dashboard.properties.show_props', compact('properties'));
    })->name('dashboard.properties');
    // dashbaord saved properties
    Route::get('/dashboard/saved_properties', function () {
        $properties = auth()->user()->savedProperties()->latest()->get();

        return view('auth.dashboard.saved_properties.saved_properties', compact('properties'));
    })->name('dashboard.savedProperties');
    // dashboard messages
    Route::get('/dashboard/messages', function () {

        $conversations = Inquiry::with('sender')
                                                ->where('receiver_id', auth()->id())
                                                ->latest()
                                                ->get()
                                                ->unique('sender_id');
        $selectedConversation = $conversations->first();
        $messages = Inquiry::where('sender_id', $selectedConversation->sender_id)
                                                                                ->where('receiver_id', auth()->id())
                                                                                ->latest()
                                                                                ->get();
        // $selectedInquiry = $inquiries->first(); // default selected
        return view('auth.dashboard.messages.messages', compact(
            'conversations',
            'selectedConversation',
            'messages'));

    })->name('dashboard.conversations');

    Route::post('/dashboard/messages/chatting/', 
    function (Request $request){
        $messages = Inquiry::where('sender_id', $request->sender_id)
        ->where('receiver_id', auth()->id())
        ->latest()
        ->get();
        return response()->json(['html'=> view('auth.dashboard.messages.messagebox', compact('messages'))->render()]);
    }
    )->name('dashboard.messages');

    Route::get('/dashboard/messages/{inquiry?}', [InquiryController::class, 'index'])
    ->name('dashboard.messages.chat');

    Route::view('/dashboard/empty/', 'auth.dashboard.empty.empty')->name('dashboard.empty');
});

