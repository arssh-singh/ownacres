<?php
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use Illuminate\Support\Facades\RateLimiter;

uses(RefreshDatabase::class);

it('shows the registration page', function () {
    $response = $this->get(route('register.form'));

    $response->assertStatus(200);
});

it('stores registration data in session and redirects to otp page', function () {

    $password = 'Password123!';
    $email = 'test+' . uniqid() . '@gmail.com';
    $response = post(route('register.sendOtp'), [
        'name' => 'Arsh Singh',
        'email' => $email,
        'password' => $password,
        'password_confirmation' => $password,
    ]);
    
    $response->assertRedirect(route('register.verifyOtp.form'));
    

    $response->assertSessionHas('register_data');

    $registerData = session('register_data');

    expect($registerData['name'])->toBe('Arsh Singh');
    expect(Hash::check($password, $registerData['password']))->toBeTrue();

    expect(session()->has('otp'))->toBeTrue();
    expect(session()->has('otp_expires_at'))->toBeTrue();
});

it('requires a name', function () {

    $response = post(route('register.sendOtp'), [
        'name' => '',
        'email' => 'arsh@gmail.com',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
    ]);

    $response->assertSessionHasErrors([
        'name',
    ]);
});

it('requires an email', function () {

    $response = post(route('register.sendOtp'), [
        'name' => 'Arsh',
        'email' => '',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
    ]);

    $response->assertSessionHasErrors([
        'email',
    ]);
});

it('requires a valid email address', function () {

    $response = post(route('register.sendOtp'), [
        'name' => 'Arsh Singh',
        'email' => 'not-an-email',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
    ]);

    $response->assertSessionHasErrors([
        'email',
    ]);
});

it('requires a unique email address', function () {

    User::factory()->create([
        'email' => 'arsh@gmail.com',
    ]);

    $response = post(route('register.sendOtp'), [
        'name' => 'Arsh Singh',
        'email' => 'arsh@gmail.com',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
    ]);

    $response->assertSessionHasErrors([
        'email',
    ]);
});

it('requires a password', function () {

    $response = post(route('register.sendOtp'), [
        'name' => 'Arsh Singh',
        'email' => 'arsh@gmail.com',
        'password' => '',
        'password_confirmation' => '',
    ]);

    $response->assertSessionHasErrors([
        'password',
    ]);
});

it('requires a password confirmation', function () {

    $response = post(route('register.sendOtp'), [
        'name' => 'Arsh Singh',
        'email' => 'arsh@gmail.com',
        'password' => 'Password123!',
        'password_confirmation' => 'DifferentPassword',
    ]);

    $response->assertSessionHasErrors([
        'password',
    ]);
});

it('rate limits otp requests', function () {

    RateLimiter::clear('send-otp:127.0.0.1');

    $data = [
        'name' => 'Arsh Singh',
        'email' => 'arsh@gmail.com',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
    ];

    // First 3 requests are allowed
    post(route('register.sendOtp'), $data);
    post(route('register.sendOtp'), $data);
    post(route('register.sendOtp'), $data);

    // 4th request should be blocked
    $response = post(route('register.sendOtp'), $data);

    $response->assertSessionHasErrors([
        'error',
    ]);

    $response->assertSessionHasErrors([
        'error' => 'Too many attempts. Please wait.',
    ]);
});