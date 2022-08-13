<?php

namespace Tests\Feature;

use App\Http\Controllers\ProductReviewController;
use App\Models\Customer;
use App\Models\Product;
use App\Models\ProductReview;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use Tests\Traits\CustomerStub;

class ProductReviewTest extends TestCase
{
    private const ENDPOINT_LIST = 'api/v1/products/%s/reviews';
    private const ENDPOINT_CREATE = 'api/v1/products/%s/reviews';

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    /**
     * @see ProductReviewController::create()
     */
    public function test_create_product_review(): void
    {
        /** @var Product $productFixture */
        $productFixture = Product::factory()->create();
        /** @var Customer $customerFixture */
        $customerFixture = Customer::factory()->create();
        Sanctum::actingAs($customerFixture);

        $data = [
            'body' => 'Test comment for product',
            'image' => CustomerStub::getFakeAvatarBase64(),
            'rating' => 4,
        ];

        $response = $this->postJson(sprintf(self::ENDPOINT_CREATE, $productFixture->id), $data);

        $response->assertStatus(201);
        $this->assertEquals($data['body'], $response->json('data.body'));
        $this->assertEquals($data['rating'], $response->json('data.rating'));
        $this->assertNotNull($response->json('data.image'));
    }

    /**
     * @see ProductReviewController::list()
     */
    public function test_product_reviews_list(): void
    {
        /** @var Product $productFixture */
        $productFixture = Product::factory()->create();
        ProductReview::factory(5)->create(['product_id' => $productFixture->id]);

        $response = $this->get(sprintf(self::ENDPOINT_LIST, $productFixture->id));

        $response->assertStatus(200);
        $this->assertEquals(5, $response->json('meta.total'));
    }
}
