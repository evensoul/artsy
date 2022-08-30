<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\Attribute;
use Fereron\CategoryTree\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class AttributeRepository
{
    /**
     * @param array $categoryIds
     * @return Collection|Attribute[]
     */
    public function getByCategoryIds(array $categoryIds): Collection
    {
        $categories = [];

        foreach ($categoryIds as $categoryId) {
            /** @var Category|null $cat */
            $cat = Category::find($categoryId);

            if (!$cat) {
                continue;
            }

            $categories[] = $categoryId;

            foreach ($cat->children as $child) {
                $categories[] = $child->id;

                foreach ($child->children as $child2) {
                    $categories[] = $child2->id;
                }
            }

            if (null !== $cat->parent) {
                $parent = $cat->parent;
                $categories[] = $parent->id;

                if (null !== $parent->parent) {
                    $categories[] = $parent->parent->id;
                }
            }
        }

        return Attribute::query()
            ->whereHas('categories', fn(Builder $query) => $query->whereIn('id', array_values($categories)))
            ->get();
    }
}
