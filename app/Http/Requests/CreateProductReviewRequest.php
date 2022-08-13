<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class CreateProductReviewRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'product_id'  => 'required|string|exists:products,id',
            'customer_id' => 'required|string|exists:customers,id',
            'body'        => 'required|string',
            'image'       => 'nullable|base64image|base64max:8000',
            'rating'      => 'required|int|min:1|max:5',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'product_id'  => $this->route('product'),
            'customer_id' => $this->user()->id,
        ]);
    }
}
