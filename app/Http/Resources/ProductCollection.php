<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Http\Requests\ProductFilterRequest;
use App\Repository\ProductRepository;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{
    /**
    * Transform the resource collection into an array.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return array
    */
    public function toArray($request)
    {
        return parent::toArray($request);
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function with($request)
    {
        $meta = [];
        if (!empty($request->_enables) && in_array(ProductFilterRequest::VISITOR_PRICE_RANGE, $request->_enables)) {
            [$min, $max] = ProductRepository::getPriceRange($request);

            $meta['price_range'] = [
                'min' => $min,
                'max' => $max,
            ];
        }

        return [
            'meta' => $meta,
        ];
    }
}
