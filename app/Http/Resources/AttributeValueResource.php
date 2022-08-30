<?php

namespace App\Http\Resources;

use App\Models\AttributeValue;
use Illuminate\Http\Resources\Json\JsonResource;

final class AttributeValueResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var AttributeValue $this */
        return [
            'id' => $this->id,
            'value' => $this->value,
        ];
    }
}
