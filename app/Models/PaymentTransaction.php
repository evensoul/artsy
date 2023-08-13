<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Enums\PaymentStatus;
use App\Models\Enums\PaymentTransactionType;
use App\Models\Traits\Uuid;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

/**
 * @property string id
 * @property string product_id
 * @property string customer_id
 * @property string type
 * @property string status
 * @property string amount
 * @property Carbon created_at
 */
class PaymentTransaction extends Model
{
    use Uuid, HasFactory;

    protected $guarded = [];

    protected $casts = [
        'type'   => PaymentTransactionType::class,
        'status' => PaymentStatus::class,
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
