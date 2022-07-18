<?php

declare(strict_types=1);

namespace App\Http\Requests;

/**
 * @property string email
 * @property string password
 */
class ApiLoginRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ];
    }
}
