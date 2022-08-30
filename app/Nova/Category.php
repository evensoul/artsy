<?php

declare(strict_types=1);

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Category extends Resource
{
    public static $model = \Fereron\CategoryTree\Models\Category::class;
    public static $title = 'title';
    public static $search = ['title'];
    public static $displayInNavigation = false;

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
