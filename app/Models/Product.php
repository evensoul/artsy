<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Enums\ProductDiscountType;
use App\Models\Enums\ProductStatus;
use App\Models\Traits\Uuid;
use Fereron\CategoryTree\Models\Category;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
 * @property float rating
 * @property boolean is_preorder
 * @property \Carbon\Carbon published_at
 * @property Customer owner
 * @property ProductReview[] reviews
 */
class Product extends Model
{
    use Uuid, HasFactory;

    protected $casts = [
        'discount_type' => ProductDiscountType::class,
        'status' => ProductStatus::class,
        'images' => 'array',
    ];

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

    public function reviews(): HasMany
    {
        return $this->hasMany(ProductReview::class);
    }
}
