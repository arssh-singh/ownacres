<?php

namespace App\Services;

// use Illuminate\Support\Facades\Mail;

class OtpService
{
    public static function send(string $email, int $otp): void
    {
        file_put_contents(
            storage_path('app/otp.json'),
            json_encode([
                'email' => $email,
                'otp' => $otp,
                'created_at' => now()->toDateTimeString()
            ], JSON_PRETTY_PRINT)
        );
    }
}