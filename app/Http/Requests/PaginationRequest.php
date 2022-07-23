<?php

declare(strict_types=1);

namespace App\Http\Requests;

/**
 * @property string perPage
 */
class PaginationRequest extends ApiRequest
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
