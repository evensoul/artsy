<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property array filter
 */
class ProductsMyFilterRequest extends FormRequest
{
    public const FILTER_STATUS = 'status';

    public function rules(): array
    {
        return [];
    }
}
