<?php

declare(strict_types=1);

namespace App\Actions\Product;

use App\Dto\ProductDto;
use App\Models\Product;
use App\Service\ImageStorage\ImageStorage;

final class UpdateProductAction
{
    public function __construct(private ImageStorage $imageStorage) {}

    public function execute(Product $product, ProductDto $dto): Product
    {
        $product->title = $dto->title;
        $product->description = $dto->description;
        $product->price = $dto->price;
        $product->discount_type = $dto->discount_type;
        $product->discount = $dto->discount;
        $product->is_preorder = $dto->is_preorder;
        $product->images = $this->uploadImages($dto->images);

        $product->save();

        $product->categories()->attach($dto->category_id);

        foreach ($dto->attributes as $attribute) {
            $product->attributesRelation()->attach($attribute);
        }

        return $product;
    }

    private function uploadImages(array $imagesToUpload): array
    {
        $images = [];
        foreach ($imagesToUpload as $image) {
            $images[] = $this->imageStorage->upload($image);
        }

        return $images;
    }
}
