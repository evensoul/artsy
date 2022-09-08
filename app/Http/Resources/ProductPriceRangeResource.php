<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

final class ProductPriceRangeResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var Product|JsonResource $this */
        return [
            'min' => $this->price_min,
            'max' => $this->price_max,
        ];
    }
}
