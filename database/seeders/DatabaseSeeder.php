<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Customer;
use App\Models\VipPackage;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Customer::factory()->create([
            'name' => 'Customer',
            'email' => 'customer@mail.com',
        ]);

         $this->call(CategorySeeder::class);
         $this->call(ProductSeeder::class);
         $this->call(BannerSeeder::class);

         VipPackage::query()->create(['days' => 5, 'price' => '15']);
         VipPackage::query()->create(['days' => 15, 'price' => '30']);
         VipPackage::query()->create(['days' => 30, 'price' => '50']);
    }
}
