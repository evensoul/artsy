<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property string driver
 */
class OauthRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'driver' => ['required', 'string', Rule::in($this->getAllowedDrivers())],
        ];
    }

    public function getAllowedDrivers(): ?string
    {
        return config('services.oauth_drivers');
    }
}
