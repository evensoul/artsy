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
            'title' => [
                'en' => $this->faker->words(1, true),
                'ru' => $this->faker->words(2, true),
                'az' => $this->faker->words(3, true),
            ],
            'order' => 0,
        ];
    }
}
