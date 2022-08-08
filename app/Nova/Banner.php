<?php

declare(strict_types=1);

namespace App\Nova;

use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Outl1ne\NovaSortable\Traits\HasSortableRows;

class Banner extends Resource
{
    use HasSortableRows;

    public static $model = \App\Models\Banner::class;
    public static $title = 'title';
    public static $search = ['title'];

    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),

            Text::make('Title')
                ->translatable()
                ->rules('required', 'max:255'),

            Text::make('Subtitle')
                ->translatable()
                ->rules('required', 'max:255'),

            Text::make('Link')
                ->translatable()
                ->rules('nullable', 'max:255'),

            Images::make('Cover')->rules('required'),
        ];
    }
}
