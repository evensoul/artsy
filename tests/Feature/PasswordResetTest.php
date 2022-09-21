<?php

namespace Tests\Feature;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordResetController;
use App\Models\Customer;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    private const ENDPOINT_FORGOT_PASSWORD = 'api/v1/auth/forgot-password';
    private const ENDPOINT_RESET_PASSWORD = 'api/v1/auth/reset-password';

    /**
     * @see PasswordResetController::createPasswordResetToken()
     */
    public function test_forgot_password(): void
    {
        $response = $this->post(self::ENDPOINT_FORGOT_PASSWORD, [
            'email' => 'customer@mail.com',
        ]);

        $response->assertStatus(204);
    }

    /**
     * @see PasswordResetController::resetPassword()
     */
    public function test_reset_password(): void
    {
        $response = $this->post(self::ENDPOINT_RESET_PASSWORD, [
            'email' => 'customer@mail.com',
            'token' => '46cf8356b472b23aa9017798428f6a744ddda69ab0c32220373182d93fd84f7b',
            'password' => 'new_password',
            'password_confirmation' => 'new_password',
        ]);

        $response->assertStatus(204);
    }
}
