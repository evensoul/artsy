<?php

namespace Tests\Feature;

use App\Http\Controllers\AttributeController;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Customer;
use App\Models\Product;
use Fereron\CategoryTree\Models\Category;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AttributeTest extends TestCase
{
    private const ENDPOINT_LIST = 'api/v1/attributes';

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    /**
     * @see AttributeController::list()
     */
    public function test_list_attributes(): void
    {
        self::markTestSkipped('wip');
        // create attribute with values
        /** @var Attribute $attributeFixture */
        $attributeFixture = Attribute::factory()->create();
        AttributeValue::factory(4)->create(['attribute_id' => $attributeFixture->id]);
        // attach categories to attribute
        $categories = Category::query()->whereNotNull('parent_id')->inRandomOrder()->limit(3)->get();
        $attributeFixture->categories()->attach($categories->pluck('id')->toArray());

        $url = sprintf(
            '%s?filter[categoryIds]=%s',
            self::ENDPOINT_LIST,
            implode(',', [$categories->first()->id, $categories->last()->id])
        );

        $response = $this->getJson($url);
        $response->assertStatus(200);

        $this->assertEquals($attributeFixture->id, $response->json('data.0.id'));
        $this->assertEquals(4, \count($response->json('data.0.values')));
    }
}
