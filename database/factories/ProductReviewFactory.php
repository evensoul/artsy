<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductReviewFactory extends Factory
{
    protected $model = ProductReview::class;

    public function definition(): array
    {
        return [
            'customer_id'  => Customer::factory()->create()->id,
            'product_id'   => Product::factory()->create()->id,
            'body'         => $this->faker->paragraph,
            'images'       => ['test.png'],
            'rating'       => \random_int(1, 5),
            'is_moderated' => true,
        ];
    }
}
