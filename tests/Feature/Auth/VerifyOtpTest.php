<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

uses(RefreshDatabase::class);

it('shows the otp verification page', function () {

    session([
        'register_data' => [
            'name' => 'Arsh Singh',
            'email' => 'test@gmail.com',
            'password' => Hash::make('Password123!'),
        ],
        'otp' => '123456',
        'otp_expires_at' => now()->addMinutes(10),
    ]);

    $response = get(route('register.verifyOtp.form'));

    $response->assertOk();
});
it('rejects an invalid otp', function () {

    session([
        'register_data' => [
            'name' => 'Arsh Singh',
            'email' => 'test@gmail.com',
            'password' => Hash::make('Password123!'),
        ],
        'otp' => '123456',
        'otp_expires_at' => now()->addMinutes(10),
    ]);

    $response = post(route('register.verifyOtp'), [
        'check_otp' => '654321',
    ]);

    $response->assertSessionHasErrors('otp');

    expect(User::count())->toBe(0);
});
it('rejects expired otp', function () {

    session([
        'register_data' => [
            'name' => 'Arsh Singh',
            'email' => 'test@gmail.com',
            'password' => Hash::make('Password123!'),
        ],
        'otp' => '123456',
        'otp_expires_at' => now()->subMinutes(10),
    ]);

    $response = post(route('register.verifyOtp'), [
        'otp' => '123456',
    ]);

    $response->assertSessionHasErrors([
        'error' => 'Invalid or expired OTP.',
    ]);

    expect(User::count())->toBe(0);
});
it('requires an otp', function () {

    session([
        'register_data' => [
            'name' => 'Arsh Singh',
            'email' => 'test@gmail.com',
            'password' => Hash::make('Password123!'),
        ],
        'otp' => '123456',
        'otp_expires_at' => now()->addMinutes(10),
    ]);

    $response = post(route('register.verifyOtp'), [
        'otp' => '',
    ]);

    $response->assertSessionHasErrors([
        'otp' => 'Please enter Otp',
    ]);
});
it('redirects to register page when otp session is missing', function () {

    $response = post(route('register.verifyOtp'), [
        'otp' => '123456',
    ]);

    $response->assertRedirect(route('register.form'));

    $response->assertSessionHasErrors([
        'error' => 'Your OTP session has expired. Please register again.',
    ]);

    expect(User::count())->toBe(0);
});
it('prevents duplicate registration', function () {

    User::factory()->create([
        'name' => 'Existing User',
        'email' => 'test@gmail.com',
    ]);

    session([
        'register_data' => [
            'name' => 'Arsh Singh',
            'email' => 'test@gmail.com',
            'password' => Hash::make('Password123!'),
        ],
        'otp' => '123456',
        'otp_expires_at' => now()->addMinutes(10),
    ]);

    $response = post(route('register.verifyOtp'), [
        'otp' => '123456',
    ]);

    $response->assertRedirect(route('register.form'));

    $response->assertSessionHasErrors([
        'error' => 'This email was just registered. Please try again.',
    ]);

    expect(User::count())->toBe(1);

    expect(session()->has('register_data'))->toBeFalse();
    expect(session()->has('otp'))->toBeFalse();
    expect(session()->has('otp_expires_at'))->toBeFalse();
});
it('creates a user, logs them in and clears the registration session after a valid otp', function () {

    $password = 'Password123!';

    session([
        'register_data' => [
            'name' => 'Arsh Singh',
            'email' => 'test@gmail.com',
            'password' => Hash::make($password),
        ],
        'otp' => '123456',
        'otp_expires_at' => now()->addMinutes(10),
    ]);

    $response = post(route('register.verifyOtp'), [
        'otp' => '123456',
    ]);

    $response->assertRedirect('dashboard');

    expect(User::count())->toBe(1);

    $user = User::first();

    expect($user)->not->toBeNull();
    expect($user->name)->toBe('Arsh Singh');
    expect($user->email)->toBe('test@gmail.com');

    expect(Hash::check($password, $user->password))->toBeTrue();

    $this->assertAuthenticated();
    $this->assertAuthenticatedAs($user);

    expect(session()->has('register_data'))->toBeFalse();
    expect(session()->has('otp'))->toBeFalse();
    expect(session()->has('otp_expires_at'))->toBeFalse();
});
