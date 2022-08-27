<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\ProductViewed;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Contracts\Auth\Guard;

class UpdateCustomerRecentViewedList
{
    private const MAX_RECENT_VIEWED_COUNT = 4;

    public function __construct(private Guard $auth) {}

    public function handle(ProductViewed $event): void
    {
        if (!$this->auth->check()) {
            return;
        }

        /** @var Customer $customer */
        $customer = $this->auth->user();

        if ($customer->recentViewedProducts->count() >= self::MAX_RECENT_VIEWED_COUNT) {
            /** @var Product $last */
            $last = $customer->recentViewedProducts->last();
            $customer->recentViewedProducts()->detach($last->id);
        }

        $customer->recentViewedProducts()->attach($event->product->id);
    }
}
