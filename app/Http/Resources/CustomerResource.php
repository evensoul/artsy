<?php

namespace App\Http\Resources;

use App\Models\Customer;
use Illuminate\Http\Resources\Json\JsonResource;

final class CustomerResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var Customer $this */
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'description' => $this->description,
            'avatar' => asset($this->avatar),
            'cover' => asset($this->cover),
            'rating' => 4.2
        ];
    }
}
