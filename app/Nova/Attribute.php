<?php

declare(strict_types=1);

namespace App\Nova;

use App\Nova\Flexible\Layouts\AttributeValueLayout;
use App\Nova\Flexible\Resolvers\AttributeValueResolver;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Panel;
use Outl1ne\MultiselectField\Multiselect;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Whitecube\NovaFlexibleContent\Flexible;

class Attribute extends Resource
{
    public static $model = \App\Models\Attribute::class;
    public static $title = 'title';
    public static $search = ['title'];

    public function fields(NovaRequest $request): array
    {
        return [
            Panel::make('General', [
                ID::make()->sortable(),

                Text::make('Title')
                    ->translatable()
                    ->rules('required', 'max:255'),

                Multiselect::make('Categories')
                    ->belongsToMany(Category::class, false),

                Flexible::make('Values')
                    ->addLayout(AttributeValueLayout::class)
                    ->resolver(AttributeValueResolver::class)
                    ->button('Add value')
            ]),
        ];
    }
}
