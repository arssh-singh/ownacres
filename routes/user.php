<?php
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\Auth\ForgotPasswordController;
    use App\Http\Controllers\Auth\VerifyOtpController;
    use App\Http\Controllers\Auth\ResetPasswordController;
    use App\Http\Controllers\Auth\LoginController;
    use App\Http\Controllers\Auth\RegisterController;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use App\Models\User;

    // creating new user routes
    Route::prefix('auth')->group(function () {
        // this newuser route looks confusing but when any user enters their detial in home page's new user panel, this routes takes those detail and put in the sign up form
        Route::get('/newuser', [RegisterController::class, 'show'])->name('newuser');

        Route::view('/register/form', 'auth.register')->name('register.form');
        Route::post('/register/send-otp', [RegisterController::class, 'sendOtp'])->name('register.sendOtp');
        Route::post('/register/resend-otp', [RegisterController::class, 'resendOtp'])->name('register.resendOtp');
        Route::get('/register/verify-otp-form', [RegisterController::class, 'verifyOtpForm'])->name('register.verifyOtp.form');
        Route::post('/register/verify-otp', [RegisterController::class, 'verifyOtp'])->name('register.verifyOtp');

        // forgot password routes
        Route::get('/forgot-password/form', [ForgotPasswordController::class, 'forgot_password_form'])->name('forgotpass.form');
        Route::post('/forgot-password/send-OTP', [ForgotPasswordController::class, 'forgot_password_sendOTP'])->name('forgotpass.sendOTP');

        Route::get('/forgot-password/verify-OTP/form', [VerifyOtpController::class, 'forgot_password_verifyOTP_form'])->name('forgotpass.verifyOTP.form');
        Route::post('/forgot-password/verify-OTP', [VerifyOtpController::class, 'verifyForgotPassOTP'])->name('forgotpass.verifyOTP');

        Route::get('/forgot-password/new-password-form', [ResetPasswordController::class, 'forgotpassnewpassform'])->name('forgotpass.newpass.form');
        Route::post('/forgot-password/change-password', [ResetPasswordController::class, 'forgotpasschangepass'])->name('forgotpass.changepass');

        // user login when account is created
        Route::get('/login', [LoginController:: class, 'show'])->name('login');
        Route::post('/login', [LoginController::class, 'login']);

        Route::post('/logout', function () {
            Auth::logout();
            return redirect(route('home'));
        })->name('logout');
    });
    


