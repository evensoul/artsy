<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Enums\ProductStatus;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::factory(10)->create(['status' => ProductStatus::ACTIVE]);
    }
}
