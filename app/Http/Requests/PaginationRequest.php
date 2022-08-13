<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string perPage
 * @property string page
 */
class PaginationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'perPage' => 'nullable|int|min:1|max:1000',
            'page' => 'nullable|int|min:1|max:1000',
        ];
    }

    protected function passedValidation(): void
    {
        $this->perPage ??= '15';
        $this->page ??= '1';
    }
}
