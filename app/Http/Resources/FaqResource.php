<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Faq;
use Illuminate\Http\Resources\Json\JsonResource;

final class FaqResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var Faq $this */
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
        ];
    }
}
