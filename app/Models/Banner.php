<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Translatable\HasTranslations;

/**
 * @property string id
 * @property string title
 * @property string subtitle
 * @property string cover
 * @property int sort_order
 * @property string|null link
 */
class Banner extends Model
{
    use Uuid, HasFactory, HasTranslations, SortableTrait;

    public $translatable = ['title', 'subtitle', 'link'];
}
