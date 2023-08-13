<?php

declare(strict_types=1);

namespace App\Actions\Product;

use App\Models\Product;
use App\Models\VipPackage;
use Carbon\Carbon;

final class MakeProductVipAction
{
    public function execute(Product $product, VipPackage $vipPackage): Product
    {
        $product->vip()->create([
            'start_date' => Carbon::today(),
            'end_date' => Carbon::today()->addDays($vipPackage->days),
        ]);

        return $product;
    }
}
