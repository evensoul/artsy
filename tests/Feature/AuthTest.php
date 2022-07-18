<?php

namespace Tests\Feature;

use App\Http\Controllers\AuthController;
use App\Models\Customer;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthTest extends TestCase
{
    private const ENDPOINT_REGISTER = 'api/v1/auth/register';
    private const ENDPOINT_LOGIN = 'api/v1/auth/login';
    private const ENDPOINT_REFRESH = 'api/v1/auth/refresh';
    private const ENDPOINT_PROFILE = 'api/v1/auth/me';

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    /**
     * @see AuthController::register()
     */
    public function test_register(): void
    {
        $faker = Factory::create();
        $customerData = [
            'name' => $faker->name,
            'email' => $faker->email,
            'password' => 'secret',
        ];

        $response = $this->post(self::ENDPOINT_REGISTER, $customerData);

        $response->assertStatus(201);
    }

    /**
     * @see AuthController::login()
     */
    public function test_login(): void
    {
        $data = [
            'email' => 'customer@mail.com',
            'password' => 'password',
        ];

        $response = $this->post(self::ENDPOINT_LOGIN, $data);

        $this->assertNotEmpty($response->json('token'));
    }

    public function test_refresh(): void
    {
        Sanctum::actingAs(Customer::factory()->create());

        $response = $this->post(self::ENDPOINT_REFRESH);

        $this->assertNotEmpty($response->json('token'));
    }

    public function test_profile()
    {
        /** @var Customer $customer */
        $customer = Customer::factory()->create();
        Sanctum::actingAs($customer);

        $response = $this->get(self::ENDPOINT_PROFILE);

        $this->assertEquals($customer->name, $response->json('data.name'));
        $this->assertEquals($customer->email, $response->json('data.email'));
    }
}
