<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Banner;
use Illuminate\Database\Eloquent\Factories\Factory;

final class BannerFactory extends Factory
{
    protected $model = Banner::class;

    public function definition(): array
    {
        return [
            'title' => [
                'en' => $this->faker->words(1, true),
                'ru' => $this->faker->words(2, true),
                'az' => $this->faker->words(3, true),
            ],
            'subtitle' => [
                'en' => $this->faker->sentence,
                'ru' => $this->faker->sentence,
                'az' => $this->faker->sentence,
            ],
            'link' => [
                'en' => sprintf("<a href='http://google.com'>%s</a>", $this->faker->words(1, true)),
                'ru' => sprintf("<a href='http://google.com'>%s</a>", $this->faker->words(2, true)),
                'az' => sprintf("<a href='http://google.com'>%s</a>", $this->faker->words(3, true)),
            ],
            'cover' => 'test.jpg',
        ];
    }
}
