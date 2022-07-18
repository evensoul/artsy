<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Profile\UpdateCustomerAction;
use App\Dto\CustomerDto;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\Resources\Json\JsonResource;

final class ProfileController
{
    public function index(Customer $customer): JsonResource
    {
        return new CustomerResource($customer);
    }

    public function update(UpdateProfileRequest $request, UpdateCustomerAction $action): JsonResource
    {
        $customer = $action->execute($request->user(), new CustomerDto(... $request->validated()));

        return new CustomerResource($customer);
    }
}
