<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\Dto\CustomerDto;
use App\Models\Customer;
use Illuminate\Contracts\Hashing\Hasher;

class RegisterAction
{
    public function __construct(private Hasher $hasher)
    {
    }

    public function execute(CustomerDto $dto): Customer
    {
        $customer = new Customer();
        $customer->name = $dto->name;
        $customer->email = $dto->email;
        $customer->phone = $dto->phone;
        $customer->password = $this->hasher->make($dto->password);
        $customer->save();

        return $customer;
    }
}
