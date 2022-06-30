<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Enums\ProductStatus;
use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string id
 * @property ProductStatus status
 * @property string title
 * @property string description
 * @property string price
 * @property string|null priceWithDiscount
 * @property integer|null discount
 * @property integer rating
 * @property boolean is_preorder
 * @property \Carbon\Carbon published_at
 */
class Product extends Model
{
    use Uuid, HasFactory;

    protected $casts = [
        'status' => ProductStatus::class,
    ];

    public function priceWithDiscount(): Attribute
    {
        return new Attribute(
            get: function (): ?string {
                if (!$this->discount) return null;
                $discountPrice = \bcdiv(\bcmul($this->price, (string)$this->discount), '100');
                return \bcsub($this->price, $discountPrice);
            }
        );
    }
}
