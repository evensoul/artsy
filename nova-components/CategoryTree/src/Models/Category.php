<?php

namespace Fereron\CategoryTree\Models;

use App\Models\Product;
use App\Models\Traits\Uuid;
use App\Nova\MenuBuilder\CategoryType;
use Carbon\Carbon;
use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Fereron\CategoryTree\MenuBuilder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

/**
 * @property int id
 * @property string title
 * @property string parent_id
 * @property Carbon created_at
 * @property Category parent
 * @property Collection|Category[] children
 */
final class Category extends Model
{
    use Uuid, HasTranslations, HasFactory;

    protected $table = 'categories';
    protected $fillable = ['menu_id', 'title', 'parent_id', 'order', 'is_active'];
    protected $with = ['children'];
    protected $class = CategoryType::class;
    public $translatable = ['title'];

    public static function boot()
    {
        parent::boot();

        static::creating(function (Category $category) {
            if (empty($category->getAttribute($category->getKeyName()))) {
                $category->setAttribute($category->getKeyName(), (string) Str::uuid());
            }

            if (null === $category->menu_id) {
                $category->menu_id = 1;
            }

            if (null === $category->order) {
                $category->order = Category::query()->max('order') + 1;
            }
        });
    }

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $appends = ['enabledClass', 'displayValue', 'fields'];

    public function menu()
    {
        return $this->belongsTo(MenuBuilder::getMenuClass());
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id')->with('children')->orderBy('order');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_category', 'category_id', 'product_id');
    }

    public function itemsChildren($parentId)
    {
        return $this->whereParentId($parentId);
    }

    public function getEnabledClassAttribute()
    {
        return ($this->is_active) ? 'enabled' : 'disabled';
    }

    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeEnabled($query)
    {
        return $query->where('is_active', 1);
    }

    public function getDisplayValueAttribute()
    {
//        return $this->value;
        return '';
    }

    public function getTypeAttribute()
    {
//        if (class_exists($this->class)) {
//            return $this->class::getIdentifier($this->value);
//        }
        return null;
    }

    public function getCustomValueAttribute()
    {
//        if (class_exists($this->class)) {
//            return $this->class::getValue($this->value, $this->data, $this->locale);
//        }
//        return $this->value;
        return '';
    }

    public function getCustomDataAttribute()
    {
        if (class_exists($this->class)) {
            return $this->class::getData([]);
        }
        return [];
    }

    public function getFieldsAttribute()
    {
        $fields = MenuBuilder::getFieldsFromMenuItemTypeClass($this->class);
        foreach ($fields as $field) {
            $field->resolve($this);
        }
        return $fields;
    }

    protected static function newFactory(): Factory
    {
        return CategoryFactory::new();
    }
}
