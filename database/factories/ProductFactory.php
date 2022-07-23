<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Enums\ProductDiscountType;
use App\Models\Enums\ProductStatus;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->words(random_int(1, 3), true),
            'owner_id' => Customer::factory()->create()->id,
            'description' => $this->faker->paragraph,
            'price' => '100',
            'discount_type' => $this->faker->randomElement(ProductDiscountType::cases()),
            'discount' => random_int(0, 1) ? random_int(10, 60) : null,
            'status' => $this->faker->randomElement(ProductStatus::cases()),
            'is_preorder' => random_int(0, 1),
            'images' => ['test.png'],
        ];
    }
}
