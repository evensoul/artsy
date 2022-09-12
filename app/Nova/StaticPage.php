<?php

declare(strict_types=1);

namespace App\Nova;

use App\Models\Enums\StaticPageKey;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;

class StaticPage extends Resource
{
    public static $model = \App\Models\StaticPage::class;
    public static $title = 'key';

    public function fields(Request $request): array
    {
        $fields = [
            Text::make('Key')->onlyOnIndex(),
            Trix::make('Body')->translatable(),
        ];

        if ($this->resource->key === StaticPageKey::HOW_WORKS->value) {
            $fields[] = Images::make('photos')->rules('required')->onlyOnForms();
        }

        return $fields;
    }

    public static function label(): string
    {
        return 'Static Pages';
    }
}
