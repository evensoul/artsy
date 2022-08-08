<?php

namespace App\Http\Resources;

use App\Models\Banner;
use Illuminate\Http\Resources\Json\JsonResource;

final class BannerResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var Banner $this */
        return [
            'id'       => $this->id,
            'title'    => $this->title,
            'subtitle' => $this->subtitle,
            'link'     => $this->link,
            'cover'    => $this->getFirstMediaUrl('cover'),
        ];
    }
}
