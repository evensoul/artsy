<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\AttributeValue;
use Illuminate\Http\Resources\Json\JsonResource;

final class ProductAttributeResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var AttributeValue $this */
        return [
            'attribute_id' => $this->attribute->id,
            'attribute_title' => $this->attribute->title,
            'attribute_value_id' => $this->id,
            'attribute_value' => $this->value,
        ];
    }
}
