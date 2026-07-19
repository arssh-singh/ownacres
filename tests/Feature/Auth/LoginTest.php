<?php
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\RateLimiter;

uses(RefreshDatabase::class);

it('shows the login page', function () {
    get(route('login'))
        ->assertOk();
});
it('requires an email', function () {

    $response = post(route('login'), [
        'email' => '',
        'password' => 'Password123!',
    ]);

    $response->assertSessionHasErrors('email');
});
it('requires a valid email address', function () {

    $response = post(route('login'), [
        'email' => 'not-an-email',
        'password' => 'Password123!',
    ]);

    $response->assertSessionHasErrors('email');
});
it('requires a password', function () {

    $response = post(route('login'), [
        'email' => 'test@gmail.com',
        'password' => '',
    ]);

    $response->assertSessionHasErrors('password');
});
it('rejects invalid credentials', function () {

    User::factory()->create([
        'email' => 'test@gmail.com',
        'password' => bcrypt('Password123!'),
    ]);

    $response = post(route('login'), [
        'email' => 'test@gmail.com',
        'password' => 'WrongPassword',
    ]);

    $response->assertSessionHasErrors([
        'email' => 'Invalid credentials',
    ]);

    $this->assertGuest();
});
it('logs in with valid credentials', function () {

    $user = User::factory()->create([
        'email' => 'test@gmail.com',
        'password' => bcrypt('Password123!'),
    ]);

    $response = post(route('login'), [
        'email' => 'test@gmail.com',
        'password' => 'Password123!',
    ]);

    $response->assertRedirect('dashboard');

    $this->assertAuthenticated();
    $this->assertAuthenticatedAs($user);
});
it('redirects to the intended page after login', function () {

    $user = User::factory()->create([
        'email' => 'test@gmail.com',
        'password' => bcrypt('Password123!'),
    ]);

    session([
        'url.intended' => '/properties/create',
    ]);

    $response = post(route('login'), [
        'email' => 'test@gmail.com',
        'password' => 'Password123!',
    ]);

    $response->assertRedirect('/properties/create');
});
it('rate limits login attempts', function () {

    RateLimiter::clear('login:127.0.0.1');

    for ($i = 0; $i < 5; $i++) {
        post(route('login'), [
            'email' => 'test@gmail.com',
            'password' => 'WrongPassword',
        ]);
    }

    $response = post(route('login'), [
        'email' => 'test@gmail.com',
        'password' => 'WrongPassword',
    ]);

    $response->assertSessionHasErrors([
        'email' => 'Too many login attempts. Please wait.',
    ]);

    $this->assertGuest();
});