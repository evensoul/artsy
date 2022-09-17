<?php

namespace App\Nova\Lenses;

use App\Models\Enums\ProductStatus;
use App\Nova\Actions\AcceptProduct;
use App\Nova\Actions\RejectProduct;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\LensRequest;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Lenses\Lens;
use Sietse85\NovaButton\Button;

class ToModerateProducts extends Lens
{
    public static function query(LensRequest $request, $query)
    {
        return $request->withOrdering($request->withFilters(
            $query->where('status', ProductStatus::MODERATION)
        ));
    }

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
                ->style('success')
                ->showOnUpdating(),

            Button::make('Reject')
                ->action(RejectProduct::class)
                ->style('danger')
                ->showOnUpdating(),
        ];
    }

    public function cards(NovaRequest $request)
    {
        return [];
    }

    public function filters(NovaRequest $request)
    {
        return [];
    }

    public function actions(NovaRequest $request)
    {
        return parent::actions($request);
    }

    public function uriKey()
    {
        return 'to-moderate-products';
    }
}
