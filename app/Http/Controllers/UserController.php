<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Services\OtpService;
class UserController extends Controller
{
    protected OtpService $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }
    public function forgot_password_form(){
        return view('auth.forgotpass.forgotpass');
    }
    public function forgot_password_sendOTP(Request $request){
        $validated = $request->validate([
                        'email' => 'required|email|exists:users,email'
                    ], [
                        'email.exists' => 'Email not available.'
                    ]);
        $otp = $this->otpService->send($validated['email']);

        session([
            'otp'=>$otp,
            'email'=>$validated['email']    
        ]);
        // Mail::raw("Your Forgot Password OTP is $otp", function ($message) use ($validated) {
        // $message->to($validated['email'])
        //         ->subject('Your OTP Code');
        // });

        return redirect(route('forgotpass.verifyOTP.form'));
    }
    public function forgot_password_verifyOTP_form(){
        return view('auth.forgotpass.verifyOTP');
    }
    public function verifyForgotPassOTP(Request $request){
        $otp = $request->input('otp');
        $correctotp = session('otp');
        if($otp!=$correctotp){
            return back()->withErrors([
            'error' => 'OTP incorrect']);
        }
        session(['otp_verified'=>true]);
        return redirect(route('forgotpass.newpass.form'));
    }
    public function forgotpassnewpassform(){
        return view('auth.forgotpass.newpass');
    }
    public function forgotpasschangepass(Request $request){
        if(!session('otp_verified')){
            return redirect()->route('forgotpass.form');
        }
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::where('email', session('email'))->first();
        
        if(!$user){
            return back()->withErrors(['error'=>'User Not Founded' . session('email')]);
        }
        $user->password = Hash::make($request->password);
        $user->save();
        
        // Clear reset session data
        session()->forget([
            'otp',
            'email',
            'otp_verified'
        ]);

        return redirect()->route('login')
        ->with('success', 'Password changed successfully.');

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
            'profile_image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $user = auth()->user();

        // Delete old image if it exists
        if ($user->profile_image) {
            Storage::disk('public')->delete($user->profile_image);
        }

        // Store new image
        $path = $request->file('profile_image')->storeAs(
            'profile_images/' . $user->id,
            'avatar.' . $request->file('profile_image')->extension(),
            'public'
        );

        $user->update(['profile_image' => $path]);

        return back()->with('success', 'Profile picture updated successfully.');
    }
}
