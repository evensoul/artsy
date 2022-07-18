<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Customer;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         Admin::factory()->create([
             'name' => 'Super Admin',
             'email' => 'admin@mail.com',
         ]);

        Customer::factory()->create([
            'name' => 'Super Customer',
            'email' => 'customer@mail.com',
        ]);

         $this->call(CategorySeeder::class);
         $this->call(ProductSeeder::class);
    }
}
