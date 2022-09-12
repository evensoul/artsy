<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Enums\StaticPageKey;
use App\Models\StaticPage;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

final class StaticPageResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var StaticPage $this */
        return [
            'key'    => $this->key,
            'body'   => $this->body,
            'photos' => $this->when(
                $this->key === StaticPageKey::HOW_WORKS->value,
                fn() => $this->getMedia('photos')->map(fn(Media $media) => $media->original_url)
            )
        ];
    }
}
