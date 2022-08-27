<?php

namespace Tests\Feature;

use App\Http\Controllers\ProductController;
use App\Models\Customer;
use App\Models\Enums\ProductStatus;
use App\Models\Product;
use Fereron\CategoryTree\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use Tests\Traits\CustomerStub;

class ProductTest extends TestCase
{
    private const ENDPOINT_CREATE = 'api/v1/products';
    private const ENDPOINT_SHOW = 'api/v1/products/%s';
    private const ENDPOINT_MY = 'api/v1/products/my';

    protected function setUp(): void
    {
        parent::setUp();
//        $this->withoutExceptionHandling();
    }

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
     * @see ProductController::create()
     */
    public function test_product_create_with_percent_discount(): void
    {
        /** @var Product $productFixture */
        $productFixture = Product::factory()->make();
        Sanctum::actingAs(Customer::factory()->create());

        $data = [
            'title' => $productFixture->title,
            'description' => $productFixture->description,
            'category_id' => Category::factory()->create()->id,
            'price' => '120',
            'discount_type' => 'percent',
            'discount' => '50',
            'is_preorder' => $productFixture->is_preorder,
            'images' => [
                CustomerStub::getFakeAvatarBase64()
            ],
        ];

        $response = $this->postJson(self::ENDPOINT_CREATE, $data);

        $response->assertStatus(201);
        $this->assertEquals($data['price'], $response->json('data.price'));
        $this->assertEquals('60', $response->json('data.price_with_discount'));
    }

    /**
     * @see ProductController::create()
     */
    public function test_product_create_with_fixed_discount(): void
    {
        /** @var Product $productFixture */
        $productFixture = Product::factory()->make();
        Sanctum::actingAs(Customer::factory()->create());

        $data = [
            'title' => $productFixture->title,
            'description' => $productFixture->description,
            'category_id' => Category::factory()->create()->id,
            'price' => '120',
            'discount_type' => 'fixed',
            'discount' => '40',
            'is_preorder' => $productFixture->is_preorder,
            'images' => [
                CustomerStub::getFakeAvatarBase64()
            ],
        ];

        $response = $this->postJson(self::ENDPOINT_CREATE, $data);

        $response->assertStatus(201);
        $this->assertEquals($data['price'], $response->json('data.price'));
        $this->assertEquals('80', $response->json('data.price_with_discount'));
    }

    public function test_my_products(): void
    {
        Product::factory(10)->create();
        Sanctum::actingAs($customer = Customer::factory()->create());
        $products = Product::factory(3)->create(['owner_id' => $customer->id]);

        $response = $this->get(self::ENDPOINT_MY);

        $response->assertStatus(200);
        $this->assertEquals(\count($products), $response->json('meta.total'));
    }

    public function test_show_product(): void
    {
        /** @var Product $productFixture */
        $productFixture = Product::factory()->create(['status' => ProductStatus::ACTIVE->value]);
        /** @var Customer $customerFixture */
        $customerFixture = Customer::factory()->create();
        Sanctum::actingAs($customerFixture);

        $response = $this->get(sprintf(self::ENDPOINT_SHOW, $productFixture->id));

        $response->assertStatus(200);
        $this->assertEquals($productFixture->title, $response->json('data.title'));
        $this->assertEquals($productFixture->description, $response->json('data.description'));

        $customerFixture->refresh();
        $this->assertEquals(1, $customerFixture->recentViewedProducts->count());
    }
}
