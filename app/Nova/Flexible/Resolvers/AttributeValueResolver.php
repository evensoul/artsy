<?php

namespace App\Nova\Flexible\Resolvers;

use App\Models\Attribute;
use Illuminate\Support\Str;
use Whitecube\NovaFlexibleContent\Value\ResolverInterface;

class AttributeValueResolver implements ResolverInterface
{
    /**
     * get the field's value
     *
     * @param  mixed  $resource
     * @param  string $attribute
     * @param  \Whitecube\NovaFlexibleContent\Layouts\Collection $layouts
     * @return \Illuminate\Support\Collection
     */
    public function get($resource, $attribute, $layouts)
    {
        $values = $resource->values()/*->orderBy('order')*/->get();

        return $values->map(function($value) use ($layouts) {
            $layout = $layouts->find('attribute-value-layout');

            if(!$layout) return;

            return $layout->duplicateAndHydrate($value->id, [
                'id' => $value->id,
                'attribute_id' => $value->attribute_id,
                'value' => $value->getTranslations('value')
            ]);
        });
    }

    /**
     * Set the field's value
     *
     * @param  Attribute  $model
     * @param  string $attribute
     * @param  \Illuminate\Support\Collection $groups
     * @return string
     */
    public function set($model, $attribute, $groups)
    {
        $class = get_class($model);

        $class::saved(function (Attribute $model) use ($groups) {
            $values = $groups->map(function($group, $index) use ($model) {
                return [
                    'id' => $group->id ?? Str::uuid()->toString(),
                    'attribute_id' => $model->id,
                    'value' => $group->value,
//                    'order' => $index
                ];
            });

            $model->values()->delete();
            $model->values()->createMany($values);
        });
    }
}
