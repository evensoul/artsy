<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string perPage
 */
class PaginationRequest extends FormRequest
{
    public function rules()
    {
        return [
            'perPage' => 'nullable|int|min:1|max:1000'
        ];
    }

    protected function passedValidation()
    {
        $this->perPage ??= '8';
    }
}
