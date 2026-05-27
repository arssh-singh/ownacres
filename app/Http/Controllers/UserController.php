<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    // 👉 Show register page
    public function showRegister()
    {
        return view('auth.register');
    }
    public function showLogin(){
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email|',
            'password' => 'required'
        ]);
        if (Auth:: attempt($credentials)){
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }
        
        return back()->withErrors([
            'email' => 'Invalid credentials'
            ])->onlyInput('email');
    }
    public function sendOTP(Request $request){
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);

        $otp = rand(100000, 999999);
        
        session([
            'register_data' => $request->all(),
            'otp'=>$otp,
        ]);
        
        Mail::raw("Your OTP is: $otp", function ($message) use ($validated) {
        $message->to($validated['email'])
                ->subject('Your OTP Code');
        });

        return redirect(route('register.verifyOTP.form'));
    }
    public function verifyOTPForm(){
        return view("auth.verifyOTP");
    }
    public function verifyOTP(Request $request){
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

        return redirect('/dashboard');
    }
}
