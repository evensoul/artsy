<?php

namespace App\Nova\Flexible\Layouts;

use Laravel\Nova\Fields\Hidden;
use Laravel\Nova\Fields\Text;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class AttributeValueLayout extends Layout
{
    protected $name = 'attribute-value-layout';
    protected $title = 'Attribute Value Layout';

    public function fields(): array
    {
        return [
            Text::make('Value')->translatable(),
            Hidden::make('Attribute ID', 'attribute_id'),
            Hidden::make('ID', 'id'),
        ];
    }

}
