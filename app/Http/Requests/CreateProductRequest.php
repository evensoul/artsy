<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Enums\ProductDiscountType;
use Illuminate\Validation\Rules\Enum;

final class CreateProductRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|string|exists:categories,id',
            'price' => 'required|numeric',
            'discount_type' => ['nullable', 'string', new Enum(ProductDiscountType::class)],
            'discount' => 'nullable|string',
            'is_preorder' => 'nullable|boolean',
            'images' => 'required|array|max:4',
            'images.*' => 'base64image|base64max:8000',
        ];
    }

    public function validatedWithCasts(): array
    {
        return array_replace($this->validated(), [
            'is_preorder' => (bool) $this->input('is_preorder'),
            'discount_type' => $this->input('discount_type') ? ProductDiscountType::from($this->input('discount_type')) : null,
        ]);
    }
}
