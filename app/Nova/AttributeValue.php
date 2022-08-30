<?php

declare(strict_types=1);

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class AttributeValue extends Resource
{
    public static $model = \App\Models\AttributeValue::class;
    public static $title = 'title';
    public static $search = ['title'];

    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),

            Text::make('Title')
                ->translatable()
                ->rules('required', 'max:255'),
        ];
    }
}
