<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Outl1ne\NovaSortable\Traits\HasSortableRows;

class VipPackage extends Resource
{
    use HasSortableRows;

    public static $model = \App\Models\VipPackage::class;
    public static $searchable = false;

    public function fields(Request $request): array
    {
        return [
            Number::make('Days')->rules('required'),
            Text::make('Price')->rules('required','numeric'),
        ];
    }
}
