<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\OtpService;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class VerifyOtpController extends Controller
{
    protected OtpService $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }
    public function forgot_password_verifyOTP_form()
    {
        if (!session()->has('forgot_password')) {
            return redirect()
                ->route('forgotpass.verifyOTP.form')
                ->with('error', 'Please request an OTP first.');
        }

        return view('auth.forgotpass.verifyOTP');
    }
    public function verifyForgotPassOTP(Request $request)
    {
        if (!session()->has('forgot_password')) {
            return redirect()
                ->route('forgotpass.form')
                ->withErrors([
                    'error' => 'Your OTP session has expired. Please try again.',
                ]);
        }

        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $forgotPassword = session('forgot_password');

        if (!$this->otpService->verify(
            $forgotPassword['otp'],
            $request->otp,
            $forgotPassword['expires_at']
        )) {
            return back()->withErrors([
                'otp' => 'Invalid or expired OTP.',
            ]);
        }

        // Mark as verified
        session([
            'forgot_password_otp_verified' => true,
        ]);

        // Remove the OTP so it can't be reused
        unset($forgotPassword['otp'], $forgotPassword['expires_at']);
        session([
            'forgot_password' => $forgotPassword,
        ]);

        return redirect(route('forgotpass.newpass.form'));
    }
}
