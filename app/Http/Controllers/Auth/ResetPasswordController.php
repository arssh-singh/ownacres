<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ResetPasswordController extends Controller
{
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
}
