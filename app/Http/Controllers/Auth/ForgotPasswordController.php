<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\OtpService;

class ForgotPasswordController extends Controller
{
    protected OtpService $otpService;
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
}
