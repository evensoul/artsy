<?php

declare(strict_types=1);

namespace App\Nova\Actions;

use App\Models\Enums\ProductStatus;
use App\Models\Product;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;

class RejectProduct extends Action
{
    public $name = 'Reject';

    public function handle(ActionFields $fields, Collection $models)
    {
        foreach ($models as $model) {
            /** @var Product $model */

            if ($model->status !== ProductStatus::MODERATION) {
                continue;
            }

            $model->status = ProductStatus::DISABLED;
            $model->save();
        }
    }
}
