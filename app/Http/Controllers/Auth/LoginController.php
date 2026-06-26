<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
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
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $key = 'login:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            return back()->withErrors(['email' => 'Too many login attempts. Please wait.']);
        }

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            RateLimiter::clear($key);
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        RateLimiter::hit($key, 60);

        return back()->withErrors(['email' => 'Invalid credentials'])->onlyInput('email');
    }
}
