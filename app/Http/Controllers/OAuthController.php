<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\OauthRequest;
use App\Models\Customer;
use Illuminate\Contracts\Hashing\Hasher;
use Laravel\Socialite\SocialiteManager;
use Laravel\Socialite\Two\AbstractProvider;
use Symfony\Component\HttpFoundation\JsonResponse;

class OAuthController
{
    public function __construct(private Hasher $hasher, private SocialiteManager $socialiteManager)
    {
    }

    public function getRedirectUrl(OauthRequest $request): JsonResponse
    {
        /** @var AbstractProvider $driver */
        $driver = $this->socialiteManager->driver($request->driver);

        return response()->json([
            'redirectUrl' => $driver->stateless()->redirect()->getTargetUrl(),
        ]);
    }

    public function authCallback(OauthRequest $request): JsonResponse
    {
        /** @var AbstractProvider $driver */
        $driver = $this->socialiteManager->driver($request->driver);

        $oauthUser = $driver->stateless()->user();
        $social_field = sprintf('%s_id', $request->driver);

        /** @var null|Customer $customer */
        $customer = Customer::query()
            ->where('email', $oauthUser->email)
            ->orWhere($social_field, $oauthUser->id)
            ->first();

        if (null === $customer) {
            $customer = new Customer();
            $customer->name = $oauthUser->name;
            $customer->email = $oauthUser->email;
            $customer->password = $this->hasher->make('secret');
            $customer->{$social_field} = $oauthUser->id;
            $customer->save();
        } else {
            $customer->{$social_field} = $oauthUser->id;
            $customer->save();
        }

        return response()->json([
            'token' => $customer->createToken('web')->plainTextToken
        ]);
    }

    public function attachSocial(OauthRequest $request): JsonResponse
    {
        /** @var AbstractProvider $driver */
        $driver = $this->socialiteManager->driver($request->driver);

        $oauthUser = $driver->stateless()->user();

        /** @var Customer $customer */
        $customer = $request->user();
        $customer->{sprintf('%s_id', $request->driver)} = $oauthUser->id;
        $customer->save();

        return response()->json(status: 204);
    }
}
