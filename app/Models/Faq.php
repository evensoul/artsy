<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Translatable\HasTranslations;

/**
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $sort_order
 */
final class Faq extends Model
{
    use Uuid, HasTranslations, SortableTrait;

    protected $table = 'faq';
    public array $translatable = ['title', 'description'];
}
