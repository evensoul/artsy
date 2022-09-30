<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\ProductViewed;

class UpdateProductViewsCountList
{
    public function handle(ProductViewed $event): void
    {
        $product = $event->product;
        $product->views_count++;
        $product->save();
    }
}
