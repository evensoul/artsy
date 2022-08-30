<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property array filter
 */
class AttributeFilterRequest extends FormRequest
{
    public const FILTER_CATEGORY_IDS = 'categoryIds';

    public function rules(): array
    {
        return [
            'filter' => 'nullable|array',
        ];
    }

    public function getFilterCategories(): array
    {
        return explode(',', $this->filter[self::FILTER_CATEGORY_IDS]);
    }
}
