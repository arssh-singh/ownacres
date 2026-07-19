<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ResetPasswordController extends Controller
{
    public function forgotpassnewpassform(){
        if(!session('forgot_password_otp_verified')){
            return redirect()->route('forgotpass.form');
        }
        return view('auth.forgotpass.newpass');
    }
    public function forgotpasschangepass(Request $request){
        if(!session('forgot_password_otp_verified')){
            return redirect()->route('forgotpass.form');
        }
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $forgotpass = session('forgot_password');

        $user = User::where('email', $forgotpass['email'])->first();
        
        if(!$user){
            return back()->withErrors(['error'=>'User Not Founded' . $forgotpass['email']]);
        }
        $user->password = Hash::make($request->password);
        $user->save();

        // Login User
        Auth::login($user);
        
        $request->session()->regenerate();
        // Clear reset session data
        session()->forget([
            'otp',
            'email',
            'otp_verified'
        ]);

        return redirect()->route('dashboard') // Change to your desired route
                ->with('success', 'Password changed successfully. You are now logged in.');

    }
}
