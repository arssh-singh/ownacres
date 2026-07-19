<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\OtpService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;


class ForgotPasswordController extends Controller
{
    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }
    protected OtpService $otpService;
    public function forgot_password_form(){
        return view('auth.forgotpass.forgotpass');
    }
    public function forgot_password_sendOTP(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'Email not available.',
        ]);

        $ipKey = 'forgot-password-ip:' . $request->ip();
        $emailKey = 'forgot-password-email:' . strtolower($validated['email']);

        if (
            RateLimiter::tooManyAttempts($ipKey, 5) ||
            RateLimiter::tooManyAttempts($emailKey, 3)
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Too many OTP requests. Please try again in a minute.'
            ], 429);
        }

        RateLimiter::hit($ipKey, 60);
        RateLimiter::hit($emailKey, 60);

        try {
            $otp = $this->otpService->send($validated['email']);

            session([
                'forgot_password' => [
                    'email' => $validated['email'],
                    'otp' => $otp,
                    'expires_at' => now()->addMinutes(10),
                ]
            ]);

            return redirect(route('forgotpass.verifyOTP.form'));

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to send OTP. Please try again.'
            ], 500);
        }
    }

}
