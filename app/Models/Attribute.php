<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\Uuid;
use Fereron\CategoryTree\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

/**
 * @property string id
 * @property string title
 * @property Collection|AttributeValue[] values
 */
class Attribute extends Model
{
    use Uuid, HasFactory, HasTranslations;

    public $translatable = ['title'];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'attribute_category', 'attribute_id', 'category_id');
    }

    public function values(): HasMany
    {
        return $this->hasMany(AttributeValue::class);
    }
}
