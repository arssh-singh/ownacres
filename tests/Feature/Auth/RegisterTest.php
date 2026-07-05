<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    private function validRegistrationData(): array
    {
        return [
            'name' => 'John Doe',
            'email' => 'abc@gmail.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];
    }
    public function test_registration_page_can_be_rendered(): void
    {
        $response = $this->get(route('register.form'));
        $response->assertStatus(200);
    }
    public function test_user_is_redirected_to_otp_verification_after_submitting_valid_registration_data(): void
    {
        // Arrange
        $data = $this->validRegistrationData();
        // Act
        $response = $this->post(route('register.sendOtp'), $data);
        // Assert
        $this->assertEquals('John Doe', session('register_data.name'));
        $this->assertEquals('abc@gmail.com', session('register_data.email'));

        $this->assertTrue(
            Hash::check('password123', session('register_data.password'))
        );
        $response->assertRedirect(route('register.verifyOtp.form'));
    }
    public function test_otp_is_stored_in_session(): void
    {
        // Arrange
        $data = $this->validRegistrationData();
        // Act
        $response = $this->post(route('register.sendOtp'), $data);
        // Assert
        $this->assertNotNull(session('otp'));
        $response->assertRedirect(route('register.verifyOtp.form'));
    }
    public function test_otp_expiration_time_is_stored_in_session(): void
    {
        // Arrange
        $data = $this->validRegistrationData();
        // Act
        $response = $this->post(route('register.sendOtp'), $data);
        // Assert
        $this->assertNotNull(session('otp_expires_at'));
        $response->assertRedirect(route('register.verifyOtp.form'));
    }

}
