<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Auth\RegisterAction;
use App\Dto\CustomerDto;
use App\Http\Requests\ApiLoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AuthController
{
    public function __construct(private Hasher $hasher)
    {
    }

    public function register(RegisterRequest $request, RegisterAction $action): JsonResource
    {
        $customer = $action->execute(new CustomerDto(... $request->validated()));

        return new CustomerResource($customer);
    }

    public function login(ApiLoginRequest $request): JsonResponse
    {
        /** @var Customer $customer */
        $customer = Customer::query()->where('email', $request->email)->first();

        if (!$customer || !$this->hasher->check($request->password, $customer->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return response()->json([
            'token' => $customer->createToken('web')->plainTextToken
        ]);
    }

    public function refresh(Request $request): JsonResponse
    {
        $user = $request->user();
        $user->tokens()->delete();

        return response()->json([
            'token' => $user->createToken('web')->plainTextToken
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $user = $request->user();
        $user->tokens()->delete();

        return response()->json(status: Response::HTTP_NO_CONTENT);
    }

    public function profile(Request $request): JsonResource
    {
        return new CustomerResource($request->user());
    }
}
