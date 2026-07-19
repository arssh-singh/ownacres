<?php
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\RateLimiter;

uses(RefreshDatabase::class);

it('shows forgot password page', function () {
    get(route('forgotpass.form'))
        ->assertOk();
});
it('requires an email', function () {

    $response = post(route('forgotpass.sendOTP'), [
        'email' => '',
    ]);

    $response->assertSessionHasErrors('email');
});
it('requires a valid email address', function () {

    $response = post(route('forgotpass.sendOTP'), [
        'email' => 'not-an-email',
    ]);

    $response->assertSessionHasErrors('email');
});
it('rejects an unknown email', function () {

    $response = post(route('forgotpass.sendOTP'), [
        'email' => 'unknown@gmail.com',
    ]);

    $response->assertSessionHasErrors([
        'email' => 'Email not available.',
    ]);
});
it('sends a reset otp', function () {

    $user = User::factory()->create([
        'email' => 'test@gmail.com',
    ]);

    $response = post(route('forgotpass.sendOTP'), [
        'email' => $user->email,
    ]);

    $response->assertRedirect(route('forgotpass.verifyOTP.form'));
});
