<?php

namespace Tests\Feature;

use App\Http\Controllers\WishListController;
use App\Models\Customer;
use App\Models\Enums\ProductStatus;
use App\Models\Product;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class WishListTest extends TestCase
{
    private const ENDPOINT_LIST = 'api/v1/products/wish-list';
    private const ENDPOINT_CREATE = 'api/v1/products/%s/wish-list';
    private const ENDPOINT_DELETE = 'api/v1/products/%s/wish-list';

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    /**
     * @see WishListController::addProduct()
     */
    public function test_add_product_to_wish_list(): void
    {
        /** @var Product $product */
        $product = Product::factory()->create();
        /** @var Customer $customer */
        $customer = Customer::factory()->create();
        Sanctum::actingAs($customer);

        $response = $this->postJson(sprintf(self::ENDPOINT_CREATE, $product->id));
        $response->assertStatus(201);

        $customer = $customer->refresh();
        $this->assertTrue($customer->wishList()->get()->isNotEmpty());
    }

    /**
     * @see WishListController::removeProduct()
     */
    public function test_delete_product_from_wish_list(): void
    {
        /** @var Product $product */
        $product = Product::factory()->create();
        /** @var Customer $customer */
        $customer = Customer::factory()->create();
        Sanctum::actingAs($customer);

        $this->postJson(sprintf(self::ENDPOINT_CREATE, $product->id));
        $response = $this->delete(sprintf(self::ENDPOINT_DELETE, $product->id));
        $response->assertStatus(204);

        $customer = $customer->refresh();
        $this->assertTrue($customer->wishList()->get()->isEmpty());
    }

    /**
     * @see WishListController::list()
     */
    public function test_wish_list(): void
    {
        /** @var Product $product */
        $product = Product::factory()->create([
            'status' => ProductStatus::ACTIVE,
        ]);
        /** @var Customer $customer */
        $customer = Customer::factory()->create();
        Sanctum::actingAs($customer);

        $this->postJson(sprintf(self::ENDPOINT_CREATE, $product->id));
        $response = $this->get(self::ENDPOINT_LIST);
        $response->assertStatus(200);

        $this->assertNotEmpty($response->json('data'));
    }
}
