<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
class LoginController extends Controller
{
    public function show(Request $request){
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
}
