<?php

namespace Tests\Feature;

use App\Http\Controllers\MyProductController;
use App\Http\Controllers\ProductController;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Customer;
use App\Models\Enums\ProductStatus;
use App\Models\Product;
use App\Models\VipPackage;
use Fereron\CategoryTree\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use Tests\Traits\CustomerStub;

class MyProductTest extends TestCase
{
    private const ENDPOINT_LIST = 'api/v1/products';
    private const ENDPOINT_CREATE = 'api/v1/products';
    private const ENDPOINT_SHOW = 'api/v1/products/%s';
    private const ENDPOINT_MY_SHOW = 'api/v1/products/my/%s';
    private const ENDPOINT_MAKE_VIP = 'api/v1/products/my/%s/vip/%s';

    /**
     * @see ProductController::create()
     */
    public function test_product_create(): void
    {
        /** @var Product $productFixture */
        $productFixture = Product::factory()->make();
        Sanctum::actingAs(Customer::factory()->create());

        $data = [
            'title' => $productFixture->title,
            'description' => $productFixture->description,
            'category_id' => Category::factory()->create()->id,
            'price' => $productFixture->price,
            'is_preorder' => $productFixture->is_preorder,
            'images' => [
                CustomerStub::getFakeAvatarBase64()
            ],
        ];

        $response = $this->postJson(self::ENDPOINT_CREATE, $data);

        $response->assertStatus(201);
        $this->assertEquals($data['title'], $response->json('data.title'));
        $this->assertEquals($data['description'], $response->json('data.description'));
        $this->assertEquals($data['price'], $response->json('data.price'));
        $this->assertEquals((bool) $data['is_preorder'], $response->json('data.is_preorder'));
    }

    /**
     * @see MyProductController::delete()
     */
    public function test_product_delete(): void
    {
        /** @var Customer $customerFixture */
        $customerFixture = Customer::factory()->create();
        /** @var Product $productFixture */
        $productFixture = Product::factory()->create(['status' => 'active', 'owner_id' => $customerFixture->id]);
        Sanctum::actingAs($customerFixture);

        $response = $this->deleteJson(sprintf(self::ENDPOINT_MY_SHOW, $productFixture->id));
        $response->assertStatus(204);
    }

    /**
     * @see MyProductController::makeVIP()
     */
    public function test_product_make_vip(): void
    {
        /** @var Customer $customerFixture */
        $customerFixture = Customer::factory()->create();
        /** @var Product $productFixture */
        $productFixture = Product::factory()->create(['status' => 'active', 'owner_id' => $customerFixture->id]);
        Sanctum::actingAs($customerFixture);
        /** @var VipPackage $vipPackage */
        $vipPackage = VipPackage::query()->where('days', 5)->first();

        $response = $this->post(sprintf(self::ENDPOINT_MAKE_VIP, $productFixture->id, $vipPackage->id));
        $response->assertStatus(200);
    }
}
