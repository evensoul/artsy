<?php

declare(strict_types=1);

namespace App\Http\Requests;

/**
 * @property string name
 * @property string email
 * @property string password
 */
class RegisterRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:customers',
            'password' => 'required|string|min:5|max:100',
        ];
    }
}
