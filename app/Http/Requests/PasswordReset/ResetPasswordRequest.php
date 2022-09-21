<?php

declare(strict_types=1);

namespace App\Http\Requests\PasswordReset;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string email
 * @property string token
 * @property string password
 */
class ResetPasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'token' => 'required',
            'email' => 'required|email|exists:customers,email',
            'password' => 'required|min:8|confirmed',
        ];
    }
}
