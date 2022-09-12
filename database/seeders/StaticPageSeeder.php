<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\StaticPage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

final class StaticPageSeeder extends Seeder
{
    public function run(): void
    {
        $staticPages = [
            [
                'id' => Str::uuid()->toString(),
                'key' => 'how_works',
                'body' => [
                    'ru' => '',
                    'en' => '',
                    'az' => '',
                ],
            ],
            [
                'id' => Str::uuid()->toString(),
                'key' => 'safe_shopping',
                'body' => [
                    'ru' => '',
                    'en' => '',
                    'az' => '',
                ],
            ],
            [
                'id' => Str::uuid()->toString(),
                'key' => 'terms_of_use',
                'body' => [
                    'ru' => '',
                    'en' => '',
                    'az' => '',
                ],
            ],
            [
                'id' => Str::uuid()->toString(),
                'key' => 'confidentiality',
                'body' => [
                    'ru' => '',
                    'en' => '',
                    'az' => '',
                ],
            ],
        ];

        foreach ($staticPages as $staticPage) {
            (new StaticPage())->create($staticPage);
        }
    }
}
