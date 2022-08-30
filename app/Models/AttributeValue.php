<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

/**
 * @property string id
 * @property string value
 * @property Attribute attribute
 */
class AttributeValue extends Model
{
    use Uuid, HasFactory, HasTranslations;

    protected $table = 'attribute_values';
    public $translatable = ['value'];
    protected $guarded = [];

    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }
}
