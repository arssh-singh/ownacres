<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\OtpService;
use App\Http\Controllers\Controller;
class UserController extends Controller
{
    protected OtpService $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    public function sendEditProfileOtp(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255'
        ]);

        try {
            $otp = $this->otpService->send($validated['email']);
            session([
                'otp'=>$otp,
                'name'=>$validated['name'],
                'email'=>$validated['email']    
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'OTP sent successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send OTP'
            ], 500);
        }
    }
    public function editProfileOtpCheck(Request $request)
    {
        sleep(1);
        if ($request->otp != session('otp')) {
            return response()->json([
                'success' => false,
                'message' => 'OTP Incorrect'
            ]);
        }

        auth()->user()->update([
            'name' => session('name'),
            'email' => session('email'),
        ]);
        session()->forget(['otp', 'name', 'email']);

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully'
        ]);
    }
    public function updateProfileImage(Request $request)
    {
        $request->validate([
            'profile_image' => ['required', 'image', 'max:2048'],
        ]);

        $user = auth()->user();

        if ($user->profile_image &&
            Storage::disk('public')->exists($user->profile_image)) {

            Storage::disk('public')->delete($user->profile_image);
        }

        $extension = $request->file('profile_image')->extension();

        $path = $request->file('profile_image')->storeAs(
            "profile_images/{$user->id}",
            "avatar.$extension",
            'public'
        );

        $user->update([
            'profile_image' => $path,
        ]);

        return response()->json([
            'success' => true,
            'profile_image_url' => Storage::url($path),
        ]);
    }
}
