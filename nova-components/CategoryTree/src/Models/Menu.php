<?php

namespace Fereron\CategoryTree\Models;

use Illuminate\Database\Eloquent\Model;
use Fereron\CategoryTree\MenuBuilder;

class Menu extends Model
{
    protected $fillable = ['id', 'name', 'slug'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable(MenuBuilder::getMenusTableName());
    }

    public function rootMenuItems()
    {
        return $this
            ->hasMany(MenuBuilder::getMenuItemClass())
            ->where('parent_id', null)
            ->orderBy('parent_id')
            ->orderBy('order');
    }

    public function formatForAPI($locale)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'locale' => $locale,
            'menuItems' => $this->rootMenuItems()
                ->where('locale', $locale)
                ->get()
                ->map(function ($menuItem) {
                    return $this->formatMenuItem($menuItem);
                })
        ];
    }

    public function formatMenuItem($menuItem)
    {
        return [
            'id' => $menuItem->id,
            'name' => $menuItem->name,
            'type' => $menuItem->type,
            'value' => $menuItem->customValue,
            'target' => $menuItem->target,
            'enabled' => $menuItem->enabled,
            'data' => $menuItem->customData,
            'children' => empty($menuItem->children) ? [] : $menuItem->children->map(function ($item) {
                return $this->formatMenuItem($item);
            })
        ];
    }
}
