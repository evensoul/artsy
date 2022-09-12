<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Outl1ne\NovaSortable\Traits\HasSortableRows;

class Faq extends Resource
{
    use HasSortableRows;

    public static $model = \App\Models\Faq::class;
    public static $title = 'title';
    public static $search = [
        'id', 'title'
    ];

    public function fields(Request $request): array
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            Text::make('Title')->rules('required', 'max:255')->translatable(),
            Textarea::make('Description')->rules('required')->translatable(),
        ];
    }
}
