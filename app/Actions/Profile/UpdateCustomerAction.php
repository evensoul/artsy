<?php

declare(strict_types=1);

namespace App\Actions\Profile;

use App\Dto\CustomerDto;
use App\Models\Customer;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

final class UpdateCustomerAction
{
    public function __construct(private Hasher $hasher)
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
            $customer->avatar = sprintf('storage/%s', $this->saveBase64Image($dto->avatar));
        }

        if (!empty($dto->cover)) {
            $customer->cover = sprintf('storage/%s', $this->saveBase64Image($dto->cover));
        }

        if (!empty($dto->password)) {
            $customer->password = $this->hasher->make($dto->password);
        }

        $customer->save();

        return $customer;
    }

    private function saveBase64Image(string $image_64): string
    {
        $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf

        $replace = substr($image_64, 0, strpos($image_64, ',')+1);

        // find substring fro replace here eg: data:image/png;base64,

        $image = str_replace($replace, '', $image_64);

        $image = str_replace(' ', '+', $image);

        $imageName = Str::random(10).'.'.$extension;

        Storage::disk('public')->put($imageName, base64_decode($image));

        return $imageName;
    }
}
