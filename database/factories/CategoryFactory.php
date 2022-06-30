<?php

declare(strict_types=1);

namespace Database\Factories;

use Fereron\CategoryTree\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

final class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        return [
            'title' => ['en' => $this->faker->words(random_int(1, 3), true)],
            'order' => 0,
        ];
    }
}
