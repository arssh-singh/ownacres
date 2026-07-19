<?php
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('has auth/forgotpasswordverifyotp page', function () {
    $user = User::factory()->create([
        'email' => 'test@gmail.com',
    ]);
    $this->withSession([
        'forgot_password' => [
            'email' => $user->email,
            'otp' => '123456',
            'expires_at' => now(),
        ],
    ]);
    $response = $this->get(route('forgotpass.verifyOTP.form'));
    $response->assertStatus(200);
});
it('allows the correct otp', function(){
    $user = User::factory()->create([
        'email'=>'test@gmail.com',
    ]);
    $this->withSession([
        'forgot_password'=>[
            'email' => $user->email,
            'otp' => '123456',
            'expires_at' => now()->addMinutes(10),
        ]
    ]);
    $response = post(route('forgotpass.verifyOTP'), [
            'otp' => '123456'
    ]);
    $response->assertRedirect(route('forgotpass.newpass.form'));
});
it('rejects expired otp', function(){
    // Arrange
    $user = User::factory()->create([
        'email' => 'test@gmail.com',
    ]);

    $this->withSession([
        'forgot_password' => [
            'email' => $user->email,
            'otp' => '123456',
            'expires_at' => now()->subMinutes(10),
        ],
    ]);

    // Act
    $response = post(route('forgotpass.verifyOTP'), [
        'otp' => '123456',
    ]);

    // Assert
    $response->assertSessionHasErrors([
        'otp' => 'Invalid or expired OTP.',
    ]);
});
it('rejects invalid otp', function(){
    // Arrange
    $user = User::factory()->create([
        'email' => 'test@gmail.com',
    ]);

    $this->withSession([
        'forgot_password' => [
            'email' => $user->email,
            'otp' => '123456',
            'expires_at' => now()->addMinutes(10),
        ],
    ]);

    // Act
    $response = post(route('forgotpass.verifyOTP'), [
        'otp' => '123455',
    ]);

    // Assert
    $response->assertSessionHasErrors([
        'otp' => 'Invalid or expired OTP.',
    ]);
});
it('allows only 6 digit otp', function(){
    // Arrange
    $user = User::factory()->create([
        'email' => 'test@gmail.com',
    ]);

    $this->withSession([
        'forgot_password' => [
            'email' => $user->email,
            'otp' => '123456',
            'expires_at' => now()->addMinutes(10),
        ],
    ]);

    // Act
    $response = post(route('forgotpass.verifyOTP'), [
        'otp' => '1234577',
    ]);

    // Assert
    $response->assertSessionHasErrors([
        'otp' => 'The otp field must be 6 digits.',
    ]);
});