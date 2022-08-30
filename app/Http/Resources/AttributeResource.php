<?php

namespace App\Http\Resources;

use App\Models\Attribute;
use Illuminate\Http\Resources\Json\JsonResource;

final class AttributeResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var Attribute $this */
        return [
            'id' => $this->id,
            'title' => $this->title,
            'values' => AttributeValueResource::collection($this->values),
        ];
    }
}
