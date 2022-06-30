<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Enums\ProductStatus;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'status' => $this->faker->randomElement(ProductStatus::cases()),
            'title' => $this->faker->words(random_int(1, 3), true),
            'description' => $this->faker->paragraph,
            'price' => '100',
            'discount' => random_int(0, 1) ? random_int(10, 60) : null,
            'is_preorder' => random_int(0, 1),
        ];
    }
}
