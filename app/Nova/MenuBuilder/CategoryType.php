<?php

declare(strict_types=1);

namespace App\Nova\MenuBuilder;

use Laravel\Nova\Fields\Text;
use Fereron\CategoryTree\MenuItemTypes\BaseMenuItemType;

class CategoryType extends BaseMenuItemType
{
    public static function getIdentifier(): string
    {
        return 'category';
    }

    public static function getName(): string
    {
        return 'Category name';
    }

    public static function getType(): string
    {
        return 'custom';
    }

    public static function getFields(): array
    {
        return [
            Text::make('Title En', 'title->en'),
            Text::make('Title Az', 'title->az'),
            Text::make('Title Ru', 'title->ru'),
        ];
    }
}
