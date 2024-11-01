<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Customer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

final class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->id === $this->route('customer');
    }

    public function rules(): array
    {
        /** @var Customer $customer */
        $customer = $this->user();

        return [
            'email'       => [
                'required', 'string', 'max:255', 'email',
                Rule::unique('customers', 'email')->ignore($customer->email, 'email')
            ],
            'name'        => 'required|string|max:255',
            'phone'       => 'required|string|phone:AZ',
            'address'     => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'avatar'      => 'nullable|base64image|base64max:8000',
            'cover'       => 'nullable|base64image|base64max:8000',

            'current_password' => [
                'nullable',
                'required_with:password',
                static function ($attribute, $value, $fail) use ($customer) {
                    if (!Hash::check($value, $customer->password)) {
                        $fail('Your password was not updated, since the provided current password does not match.');
                    }
                }
            ],
            'password' => 'nullable|string|confirmed|min:6'
        ];
    }
}
