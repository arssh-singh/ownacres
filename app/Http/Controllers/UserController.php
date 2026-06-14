<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
class UserController extends Controller
{
    public function putinregister(Request $request){
        // printing request data
        return redirect()->route('register', [
            'name'  => $request->name,
            'email' => $request->email,
        ]);
    }
    // 👉 Show register page
    public function showRegister()
    {
        return view('auth.register');
    }
    public function showLogin(Request $request){
        if ($request->has('redirect')) {
            session(['url.intended' => $request->redirect]);
        }
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

        return redirect()->intended('dashboard');
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
        $otp = random_int(100000, 999999);

        session([
            'otp'=>$otp,
            'email'=>$validated['email']    
        ]);

        Mail::raw("Your Forgot Password OTP is $otp", function ($message) use ($validated) {
        $message->to($validated['email'])
                ->subject('Your OTP Code');
        });

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
