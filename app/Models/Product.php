<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Enums\ProductDiscountType;
use App\Models\Enums\ProductStatus;
use App\Models\Traits\Uuid;
use Carbon\Carbon;
use Fereron\CategoryTree\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

/**
 * @property string id
 * @property string owner_id
 * @property string title
 * @property string description
 * @property string price
 * @property string|null priceWithDiscount
 * @property ProductDiscountType|null discount_type
 * @property integer|null discount
 * @property ProductStatus status
 * @property array images
 * @property integer views_count
 * @property float rating
 * @property boolean is_preorder
 * @property \Carbon\Carbon published_at
 * @property Customer owner
 * @property ProductReview[] reviews
 * @property null|ProductVip activeVip
 */
class Product extends Model
{
    use Uuid, HasFactory, Searchable;

    protected $casts = [
        'discount_type' => ProductDiscountType::class,
        'status' => ProductStatus::class,
        'images' => 'array',
    ];

    public function searchableAs(): string
    {
        return 'products_index';
    }

    public function toSearchableArray(): array
    {
        return [
            'title' => $this->title,
        ];
    }

    protected function makeAllSearchableUsing(Builder $query): Builder
    {
        return $query->with('categories');
    }

    public function shouldBeSearchable(): bool
    {
        return $this->status === ProductStatus::ACTIVE;
    }

    public function priceWithDiscount(): Attribute
    {
        return new Attribute(
            get: function (): ?string {
                if (!$this->discount) return null;

                if ($this->discount_type === ProductDiscountType::FIXED) {
                    return \bcsub($this->price, (string)$this->discount);
                } elseif ($this->discount_type === ProductDiscountType::PERCENT) {
                    $discountPrice = \bcdiv(\bcmul($this->price, (string)$this->discount), '100');
                    return \bcsub($this->price, $discountPrice);
                }

                throw new \LogicException('Invalid discount type');
            }
        );
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'owner_id');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'product_category', 'product_id', 'category_id');
    }

    public function attributesRelation(): BelongsToMany
    {
        return $this->belongsToMany(AttributeValue::class, 'product_attributes', 'product_id', 'attribute_value_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(ProductReview::class);
    }

    public function vip(): HasMany
    {
        return $this->hasMany(ProductVip::class);
    }

    public function activeVip(): HasOne
    {
        return $this->hasOne(ProductVip::class)
            ->where('start_date', '<', Carbon::now())
            ->where('end_date', '>', Carbon::now());
    }
}
