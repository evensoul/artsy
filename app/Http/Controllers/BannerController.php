<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\BannerResource;
use App\Models\Banner;
use Illuminate\Http\Resources\Json\JsonResource;

class BannerController
{
    public function list(): JsonResource
    {
        $bannersQuery = Banner::query()->orderByDesc('sort_order');

        return BannerResource::collection($bannersQuery->get());
    }
}
