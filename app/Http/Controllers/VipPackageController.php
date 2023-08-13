<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\BannerResource;
use App\Models\VipPackage;
use Illuminate\Http\Resources\Json\JsonResource;

class VipPackageController
{
    public function list(): JsonResource
    {
        $bannersQuery = VipPackage::query()->orderBy('sort_order');

        return BannerResource::collection($bannersQuery->get());
    }
}
