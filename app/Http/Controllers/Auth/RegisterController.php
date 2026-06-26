<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Services\OtpService;
use Illuminate\Support\Facades\RateLimiter;
class RegisterController extends Controller
{
    public function __construct(
        private OtpService $otpService
    ){}
    public function show(Request $request){
        return redirect()->route('register.form', [
            'name'  => $request->name,
            'email' => $request->email,
        ]);
    }
    public function sendOtp(Request $request){
        $validated = $request->validate(
            [
                'name' => [
                    'required',
                    'string',
                    'min:2',
                    'max:100',
                    'regex:/.*\S.*/', // Reject empty/whitespace-only names
                ],

                'email' => [
                    'required',
                    'string',
                    'email:rfc,dns',
                    'max:255',
                    'lowercase', // Laravel 11+
                    'unique:users,email',
                ],

                'password' => [
                    'required',
                    'string',
                    'min:6',
                    'confirmed',
                    'regex:/.*\S.*/',
                ],
            ],
            [
                // Name
                'name.required' => '*Please enter your name.',
                'name.string' => '*Your name must be valid text.',
                'name.min' => '*Your name must be at least 2 characters long.',
                'name.max' => '*Your name may not be greater than 100 characters.',
                'name.regex' => '*Your name cannot be empty or contain only spaces.',

                // Email
                'email.required' => '*Please enter your email address.',
                'email.string' => '*Your email address must be valid text.',
                'email.email' => '*Please enter a valid email address.',
                'email.max' => '*Your email address may not be greater than 255 characters.',
                'email.unique' => '*An account with this email already exists.',
                'email.lowercase' => '*Email addresses must be lowercase.',

                // Password
                'password.required' => '*Please enter a password.',
                'password.string' => '*Password must be valid text.',
                'password.min' => '*Your password must be at least 6 characters long.',
                'password.confirmed' => '*The passwords do not match.',
                'password.regex' => '*Password cannot be empty or contain only spaces.',
            ]
        );

        $key = 'send-otp:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 3)) {
            return back()->withErrors(['error' => 'Too many attempts. Please wait.']);
        }
        RateLimiter::hit($key, 60);

        $otp = $this->otpService->send($validated['email']);

        session([
            'register_data' => [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ],
            'otp'=>$otp,
            'otp_expires_at'=>$this->otpService->expiresAt(),
        ]);

        return redirect(route('register.verifyOtp.form'));
    }
    public function verifyOtpForm(){
        if (!session()->has('otp') || !session()->has('register_data')) {
            return redirect()->route('register.form');
        }

        return view('auth.verifyOTP', [
            'expiresAt' => session('otp_expires_at'),
        ]);
    }
    public function resendOtp(Request $request)
    {
        if (!session()->has('register_data')) {
            return redirect()->route('register.form')
                ->withErrors([
                    'error' => 'Registration session expired.'
                ]);
        }
        $key = 'resend-otp:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 3)) {
            return back()->withErrors(['error' => 'Too many attempts. Please wait.']);
        }
        RateLimiter::hit($key, 60);

        $registerData = session('register_data');

        $otp = $this->otpService->send($registerData['email']);

        session([
            'otp' => $otp,
            'otp_expires_at' => $this->otpService->expiresAt(),
        ]);

        return back()->with('success', 'A new OTP has been sent.');
    }
    public function verifyOtp(Request $request){
        if (!session()->has('otp')) {
            return redirect()->route('register.form')
                ->withErrors([
                    'error' => 'Your OTP session has expired. Please register again.'
                ]);
        }

        $storedOtp = session('otp');
        $otp_expires_at = session('otp_expires_at');

        // if otp is not empty
        $request->validate(['otp' => 'required|string'],['otp.required'=>'Please enter Otp']);

        if(!$this->otpService->verify($storedOtp, $request->otp, $otp_expires_at)){
            return back()->withErrors([
                'error' => 'Invalid or expired OTP.'
            ]);
        }
        $validated = session('register_data');

        if (User::where('email', $validated['email'])->exists()) {
            session()->forget(['otp', 'register_data', 'otp_expires_at']);
            return redirect()->route('register.form')
                ->withErrors(['error' => 'This email was just registered. Please try again.']);
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        Auth::login($user);

        session()->forget(['otp', 'register_data', 'otp_expires_at']);

        return redirect()->intended('dashboard');
    }
}
