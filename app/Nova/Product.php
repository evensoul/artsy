<?php

declare(strict_types=1);

namespace App\Nova;

use App\Models\Enums\ProductStatus;
use App\Nova\Actions\AcceptProduct;
use App\Nova\Actions\RejectProduct;
use App\Nova\Lenses\ToModerateProducts;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Sietse85\NovaButton\Button;

class Product extends Resource
{
    public static $model = \App\Models\Product::class;
    public static $title = 'title';
    public static $search = ['id', 'title'];

    public function fields(NovaRequest $request): array
    {
        return [
            Text::make('Title')->rules('required', 'max:255'),
            Textarea::make('Description'),
            Text::make('Price')->rules('required','number'),
            Text::make('Discount'),
            Text::make('Discount Type', 'discount_type')->readonly(),

            Button::make('Accept')
                ->action(AcceptProduct::class)
                ->showOnIndex(false)
                ->visible($this->status === ProductStatus::MODERATION)
                ->style('success')
                ->showOnUpdating(),

            Button::make('Reject')
                ->action(RejectProduct::class)
                ->showOnIndex(false)
                ->visible($this->status === ProductStatus::MODERATION)
                ->style('danger')
                ->showOnUpdating(),
        ];
    }

    public function lenses(NovaRequest $request): array
    {
        return [
            new ToModerateProducts,
        ];
    }

    public static function authorizedToCreate(Request $request): bool
    {
        return false;
    }
}
