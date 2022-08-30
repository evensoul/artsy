<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\AttributeValue;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

final class AttributeValueFactory extends Factory
{
    protected $model = AttributeValue::class;

    public function definition(): array
    {
        return [
            'id' => Str::uuid()->toString(),
            'value' => [
                'en' => $this->faker->words(1, true),
                'ru' => $this->faker->words(2, true),
                'az' => $this->faker->words(3, true),
            ],
        ];
    }
}
