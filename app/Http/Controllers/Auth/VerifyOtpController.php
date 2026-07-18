<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VerifyOtpController extends Controller
{
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
}
