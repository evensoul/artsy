<?php

namespace App\Nova;

use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

class Customer extends Resource
{
    public static $model = \App\Models\Customer::class;

    public static $title = 'name';

    public static $search = [
        'id', 'name', 'email', 'phone'
    ];

    public function fields(NovaRequest $request): array
    {
        return [
            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Email')
                ->sortable()
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),

            Text::make('Phone'),
            Text::make('Address'),
            Textarea::make('Description'),
        ];
    }
}
