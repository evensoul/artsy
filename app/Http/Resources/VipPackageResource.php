<?php

namespace App\Http\Resources;

use App\Models\VipPackage;
use Illuminate\Http\Resources\Json\JsonResource;

final class VipPackageResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var VipPackage $this */
        return [
            'id'    => $this->id,
            'days'  => $this->days,
            'price' => $this->price,
        ];
    }
}
