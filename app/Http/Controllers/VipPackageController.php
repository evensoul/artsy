<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\VipPackageResource;
use App\Models\VipPackage;
use Illuminate\Http\Resources\Json\JsonResource;

class VipPackageController
{
    public function list(): JsonResource
    {
        $vipPackagesQuery = VipPackage::query()->orderBy('sort_order');

        return VipPackageResource::collection($vipPackagesQuery->get());
    }
}
