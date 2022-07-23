<?php

declare(strict_types=1);

namespace Database\Seeders;

use Fereron\CategoryTree\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
//        DB::table('categories')->truncate();

        Category::factory(6)
            ->has(
                Category::factory()
                    ->count(4)
                    ->state(function (array $attributes, Category $rootCategory) {
                        return ['parent_id' => $rootCategory->id];
                    })
                    ->has(
                        Category::factory()
                            ->count(5)
                            ->state(function (array $attributes, Category $secondCategory) {
                                return ['parent_id' => $secondCategory->id];
                            }),
                        'children'
                    ),
                'children'
            )
            ->create();
    }
}
