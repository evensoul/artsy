<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property array _enables
 * @property array filter
 *
 * @property array categoryIds
 * @property string ownerId
 * @property string category_ids
 * @property string sort
 * @property string price
 */
class ProductFilterRequest extends FormRequest
{
    public const VISITOR_OWNER_DATA = 'ownerData';
    public const VISITOR_PRICE_RANGE = 'priceRange';

    public const FILTER_OWNER_ID = 'ownerId';
    public const FILTER_ATTRIBUTE_VALUES_IDS = 'attributeValuesIds';
    public const FILTER_PRICE_MIN = 'price_min';
    public const FILTER_PRICE_MAX = 'price_max';
    public const FILTER_HAS_DISCOUNT = 'has_discount';

    public const AVAILABLE_SORT = [
        'price_asc',
        'price_desc',
    ];

    public function rules(): array
    {
        return [
            '_enables' => 'nullable|array',
            '_enables.*' => ['nullable', 'string', Rule::in([self::VISITOR_OWNER_DATA, self::VISITOR_PRICE_RANGE])],
            'filter' => 'nullable|array',
            'sort' => ['nullable', 'string', Rule::in(self::AVAILABLE_SORT)],
        ];
    }

    public function getSortColumn(): ?string
    {
        return $this->query('sort')
            ? substr($this->query('sort'), 0, strpos($this->query('sort'), "_"))
            : null;
    }

    public function getSortDirection(): ?string
    {
        return $this->query('sort')
            ? substr($this->query('sort'), strpos($this->query('sort'), "_") + 1)
            : null;
    }

    public function getFilterAttributeValues(): array
    {
        return explode(',', $this->filter[self::FILTER_ATTRIBUTE_VALUES_IDS]);
    }
}
