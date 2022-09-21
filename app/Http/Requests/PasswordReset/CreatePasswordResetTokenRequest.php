<?php

declare(strict_types=1);

namespace App\Http\Requests\PasswordReset;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string email
 */
class CreatePasswordResetTokenRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|string|email|exists:customers,email',
        ];
    }
}
