<?php

declare(strict_types=1);

namespace App\Actions\Profile;

use App\Dto\CustomerDto;
use App\Models\Customer;
use App\Service\ImageStorage\ImageStorage;
use Illuminate\Contracts\Hashing\Hasher;

final class UpdateCustomerAction
{
    public function __construct(private Hasher $hasher, private ImageStorage $imageStorage)
    {
    }

    public function execute(Customer $customer, CustomerDto $dto): Customer
    {
        $customer->name = $dto->name;
        $customer->email = $dto->email;
        $customer->phone = $dto->phone;
        $customer->address = $dto->address;
        $customer->description = $dto->description;

        if (!empty($dto->avatar)) {
            $customer->avatar = sprintf('storage/%s', $this->imageStorage->upload($dto->avatar));
        }

        if (!empty($dto->cover)) {
            $customer->cover = sprintf('storage/%s', $this->imageStorage->upload($dto->cover));
        }

        if (!empty($dto->password)) {
            $customer->password = $this->hasher->make($dto->password);
        }

        $customer->save();

        return $customer;
    }
}
