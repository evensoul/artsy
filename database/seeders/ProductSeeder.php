<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Enums\ProductStatus;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        /** @var Customer[] $customers */
        $customers = Customer::factory(5)->create();

        foreach ($customers as $customer) {
            Product::factory(7)
                ->create([
                    'status' => ProductStatus::ACTIVE,
                    'owner_id' => $customer->id
                ]);
        }
    }
}
