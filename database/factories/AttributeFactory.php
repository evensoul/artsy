<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Attribute;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

final class AttributeFactory extends Factory
{
    protected $model = Attribute::class;

    public function definition(): array
    {
        return [
            'id' => Str::uuid()->toString(),
            'title' => [
                'en' => $this->faker->words(1, true),
                'ru' => $this->faker->words(2, true),
                'az' => $this->faker->words(3, true),
            ],
        ];
    }
}
