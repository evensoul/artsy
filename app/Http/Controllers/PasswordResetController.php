<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\PasswordReset\CreatePasswordResetTokenRequest;
use App\Http\Requests\PasswordReset\ResetPasswordRequest;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class PasswordResetController
{
    public function __construct(private PasswordBroker $passwordBroker, private Hasher $hasher) {}

    public function createPasswordResetToken(CreatePasswordResetTokenRequest $request): JsonResponse
    {
        $status = $this->passwordBroker->sendResetLink($request->validated());

        if ($status !== Password::RESET_LINK_SENT) {
            throw new BadRequestHttpException();
        }

        return response()->json(status: Response::HTTP_NO_CONTENT);
    }

    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        $status = $this->passwordBroker->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            fn($user, $password) => $user->forceFill(['password' => $this->hasher->make($password)])->save()
        );

        if ($status !== Password::PASSWORD_RESET) {
            throw new BadRequestHttpException();
        }

        return response()->json(status: Response::HTTP_NO_CONTENT);
    }
}
