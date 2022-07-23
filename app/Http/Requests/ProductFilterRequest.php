<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property array _enables
 * @property array categoryIds
 * @property string ownerId
 */
class ProductFilterRequest extends FormRequest
{
    public const VISITOR_OWNER_DATA = 'ownerData';
    public const VISITOR_PRICE_RANGE = 'priceRange';

    public function rules()
    {
        return [
            '_enables' => 'nullable|array',
            '_enables.*' => ['nullable', 'string', Rule::in([self::VISITOR_OWNER_DATA, self::VISITOR_PRICE_RANGE])],
        ];
    }
}
