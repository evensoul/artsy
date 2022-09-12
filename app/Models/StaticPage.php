<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

/**
 * @property string id
 * @property string key
 * @property string body
 */
class StaticPage extends Model implements HasMedia
{
    use Uuid, HasTranslations, InteractsWithMedia;

    protected $table = 'static_pages';
    protected $guarded = [];
    public array $translatable = ['body'];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('photos');
    }
}
