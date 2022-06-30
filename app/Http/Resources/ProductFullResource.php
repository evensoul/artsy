<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

final class ProductFullResource extends JsonResource
{
    private const images = [
        'https://i.etsystatic.com/22592098/r/il/9c7b3b/3566076413/il_1588xN.3566076413_a0ym.jpg',
        'https://i.etsystatic.com/8258008/r/il/20a025/1893992926/il_1588xN.1893992926_2of1.jpg',
        'https://i.etsystatic.com/11537882/r/il/91eaa8/2093533256/il_1588xN.2093533256_oajr.jpg',
        'https://i.etsystatic.com/24977349/r/il/c4ce9b/3166053923/il_1588xN.3166053923_s327.jpg',
        'https://i.etsystatic.com/17860793/r/il/582f59/1766951619/il_1588xN.1766951619_sww3.jpg',
        'https://i.etsystatic.com/15510096/r/il/0151d6/3042403463/il_1588xN.3042403463_np5r.jpg',
        'https://i.etsystatic.com/10664644/r/il/187135/2333975199/il_1588xN.2333975199_lsxx.jpg',
    ];

    public function toArray($request): array
    {
        /** @var Product $this */
        return [
            'id' => $this->id,
            'images' => [
                self::images[0], self::images[1], self::images[2]
            ],
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'price_with_discount' => $this->priceWithDiscount,
            'discount' => $this->discount,
            'published_at' => $this->published_at,
            'rating' => $this->rating,
            'ratings_count' => \random_int(10, 200),
            'is_preorder' => \random_int(0, 1),
            'is_wish' => \random_int(0, 100) < 5,
        ];
    }
}
