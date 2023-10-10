<?php

declare(strict_types=1);

namespace App\Nova;

use Fereron\CategoryTree\Models\Category as CategoryModel;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Category extends Resource
{
    public static $model = CategoryModel::class;
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

            Boolean::make('Is active'),

            Select::make('Parent category', 'parent_id')
                ->options(self::buildParentCategorySelectOptions($request->resourceId))
                ->rules('required', 'max:255'),
        ];
    }

    public static function redirectAfterCreate(NovaRequest $request, $resource): string
    {
        return '/resources/nova-menus/1';
    }

    public static function redirectAfterUpdate(NovaRequest $request, $resource): string
    {
        return '/resources/nova-menus/1';
    }

    private static function buildParentCategorySelectOptions(?string $currentId = null): array
    {
        /** @var CategoryModel[] $cats */
        $cats = CategoryModel::query()
            ->with(['children'])
            ->where('is_active', true)
            ->whereNull('parent_id')
            ->orderBy('order')
            ->get();

        $arr = [];

        foreach ($cats as $cat) {
            $arr[$cat->id] = $cat->title;

            foreach ($cat->children as $child) {
                $arr[$child->id] = '-- ' . $child->title;

                foreach ($child->children as $child1) {
                    $arr[$child1->id] = '---- ' . $child1->title;
                }
            }
        }

        if ($currentId) {
            unset($arr[$currentId]);
        }

        return $arr;
    }
}
