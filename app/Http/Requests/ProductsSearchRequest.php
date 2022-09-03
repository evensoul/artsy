<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string q
 */
class ProductsSearchRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'query' => 'string|min:2|max:255',
        ];
    }
}
