<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

/**
 * @property string id
 * @property string title
 * @property string subtitle
 * @property int sort_order
 * @property string|null link
 */
class Banner extends Model implements Sortable, HasMedia
{
    use Uuid, HasFactory, HasTranslations, SortableTrait, InteractsWithMedia;

    public $translatable = ['title', 'subtitle', 'link'];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cover')->singleFile();
    }
}
