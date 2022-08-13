<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\Uuid;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string id
 * @property string customer_id
 * @property string product_id
 * @property string body
 * @property array images
 * @property int rating
 * @property boolean is_moderated
 * @property Customer customer
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class ProductReview extends Model
{
    use Uuid, HasFactory;

    protected $casts = [
        'images' => 'array',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
