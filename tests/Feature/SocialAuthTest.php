<?php

namespace Tests\Feature;

use App\Http\Controllers\AuthController;
use App\Models\Customer;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class SocialAuthTest extends TestCase
{
    private const ENDPOINT_AUTH_GOOGLE = 'api/v1/auth/google';
    private const ENDPOINT_AUTH_GOOGLE_CALLBACK = 'api/v1/auth/google/callback';

    public function test_auth_google(): void
    {
        self::markTestSkipped('wip');
        $response = $this->get(self::ENDPOINT_AUTH_GOOGLE);
        $response->dd();
    }

    public function test_auth_callback_google(): void
    {
        self::markTestSkipped('wip');
        $this->withoutExceptionHandling();
        $queryParams = '?code=4%2F0ARtbsJr5zVnrsU7IiuraW53iGG7M1al7WsWdLX4GJkKWVZ7xVBg_dRvM9ECcrND_0m_eEA&scope=email+profile+openid+https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.profile+https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.email&authuser=0&prompt=consent';

        $response = $this->get(self::ENDPOINT_AUTH_GOOGLE_CALLBACK . $queryParams);
        $response->dd();
    }
}
