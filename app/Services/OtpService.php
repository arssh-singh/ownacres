<?php

namespace App\Services;

use Carbon\Carbon;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;

class OtpService
{
    /**
     * Generate a numeric OTP.
     */
    public function generate(int $length = 6): string
    {
        $min = (int) str_pad('1', $length, '0');
        $max = (int) str_pad('', $length, '9');

        return (string) random_int($min, $max);
    }
    /**
     * Send OTP to an email address.
     */

    public function sendMailToJson(string $email): string{
        $otp = $this->generate();
        $mail = new OtpMail($otp);
        $html = $mail->render();

        $data = [
            'to' => $email,
            'otp' => $otp,
            'subject' => $mail->envelope()->subject,
            'html' => $html,
            'sent_at' => now()->toDateTimeString(),
        ];

        File::put(
            storage_path('app/otp.json'),
            json_encode($data, JSON_PRETTY_PRINT)
        );

        return $otp;
    }
    public function send(string $email): string
    {   
        // if (app()->environment('production')) {
            // Production
        $otp = $this->generate();
        Mail::to($email)->send(new OtpMail($otp));
        // } else {
        //     // Local, staging, testing, etc.
        //     $otp = $this->sendMailToJson($email);
        // }

        return $otp;
    }


    /**
     * Get an expiry time.
     */
    public function expiresAt(int $minutes = 1): Carbon
    {
        return Carbon::now()->addMinutes($minutes);
    }

    /**
     * Check if an OTP has expired.
     */
    public function isExpired(Carbon|string $expiresAt): bool
    {
        return Carbon::now()->greaterThan($expiresAt);
    }

    /**
     * Verify an OTP.
     */
    public function verify(
        string $storedOtp,
        string $enteredOtp,
        Carbon|string $expiresAt
    ): bool {
        return $storedOtp === $enteredOtp
            && ! $this->isExpired($expiresAt);
    }
}