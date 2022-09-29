<?php

namespace Tests\Feature;

use App\Http\Controllers\CustomerController;
use App\Models\Customer;
use Faker\Factory;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use Tests\Traits\CustomerStub;

class CategoriesTest extends TestCase
{
    private const ENDPOINT_VIEW = 'api/v1/customers/%s';
    private const ENDPOINT_UPDATE = 'api/v1/customers/%s';
    private const ENDPOINT_LIST_POPULAR = 'api/v1/customers/popular';

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function view_profile(): void
    {
//        /** @var Customer $customer */
//        $customer = Customer::factory()->create();

        $response = $this->json('get', sprintf(self::ENDPOINT_VIEW, '48571f82-638d-4037-b903-79c70e63c843'));

//        $response->dd();
    }

    /**
     * @see CustomerController::update()
     */
    public function test_update_profile(): void
    {
        $faker = Factory::create();
        /** @var Customer $customer */
        $customer = Customer::factory()->create();
        Sanctum::actingAs($customer);

        $customerData = [
            'name' => 'Super test',
            'email' => $faker->safeEmail,
            'phone' => '+994551231212',
            'address' => 'Аджеми Нахчывани, 53, Баку 1010, Азербайджан',
            'description' => 'Один из ведущих мировых дизайнерских брендов стиля, получивший признание за прославление сущности классического американского стиля.',
            'avatar' => CustomerStub::getFakeAvatarBase64(),
            'cover' => CustomerStub::getFakeCoverBase64(),
        ];

        $response = $this->patchJson(sprintf(self::ENDPOINT_UPDATE, $customer->id), $customerData);

        $response->assertStatus(200);

        $this->assertEquals($customerData['name'], $response->json('data.name'));
        $this->assertEquals($customerData['email'], $response->json('data.email'));
        $this->assertEquals($customerData['phone'], $response->json('data.phone'));
        $this->assertEquals($customerData['address'], $response->json('data.address'));
        $this->assertEquals($customerData['description'], $response->json('data.description'));
    }

    /**
     * @see CustomerController::update()
     */
    public function test_update_profile_with_his_email(): void
    {
        /** @var Customer $customer */
        $customer = Customer::factory()->create();
        Sanctum::actingAs($customer);

        $customerData = [
            'name' => $customer->name,
            'email' => $customer->email,
            'phone' => $customer->phone,
        ];

        $response = $this->patchJson(sprintf(self::ENDPOINT_UPDATE, $customer->id), $customerData);
        $response->assertStatus(200);

        $this->assertEquals($customerData['name'], $response->json('data.name'));
        $this->assertEquals($customerData['email'], $response->json('data.email'));
        $this->assertEquals($customerData['phone'], $response->json('data.phone'));
    }


    /**
     * @see CustomerController::update()
     */
    public function test_cant_update_other_profile(): void
    {
        $this->withExceptionHandling();

        /** @var Customer $customer */
        $customer = Customer::factory()->create();
        Sanctum::actingAs(Customer::factory()->create());

        $response = $this->patchJson(sprintf(self::ENDPOINT_UPDATE, $customer->id), []);

        $response->assertStatus(403);
    }

    /**
     * @see CustomerController::listPopular()
     */
    public function test_list_popular_customers(): void
    {
        Customer::factory(5)->create();

        $response = $this->get(self::ENDPOINT_LIST_POPULAR);
        $response->assertStatus(200);
    }
}
