<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class RegisterController extends Controller
{
    public function show(Request $request){
        return redirect()->route('register.form', [
            'name'  => $request->name,
            'email' => $request->email,
        ]);
    }
    public function sendOtp(Request $request){
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed'
        
            ],
            [
                'name.required' => 'Please enter your name.',
                'email.required' => 'Please enter your email address.',
                'email.email' => 'Please enter a valid email address.',
                'email.unique' => 'An account with this email already exists.',
                'password.required' => 'Please enter a password.',
                'password.min' => 'Your password must be at least 6 characters long.',
                'password.confirmed' => 'The passwords do not match.'
            ]
        );

        $otp = rand(100000, 999999);
        
        session([
            'register_data' => $request->all(),
            'otp'=>$otp,
        ]);
        
        Mail::raw("Your OTP is: $otp", function ($message) use ($validated) {
        $message->to($validated['email'])
                ->subject('Your OTP Code');
        });

        return redirect(route('register.verifyOtp.form'));
    }
    public function verifyOtpForm(){
        return view("auth.verifyOTP");
    }
    public function verifyOtp(Request $request){
        $otp = $request->input('otp');
        $correctotp = session('otp');
        if($otp!=$correctotp){
            return back()->withErrors([
            'error' => 'OTP incorrect']);
        }
        $validated = session('register_data');

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);

        session()->forget(['otp', 'register_data']);

        return redirect()->intended('dashboard');
    }
}
