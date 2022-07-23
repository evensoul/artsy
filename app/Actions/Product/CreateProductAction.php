<?php

declare(strict_types=1);

namespace App\Actions\Product;

use App\Dto\ProductDto;
use App\Models\Product;
use App\Service\ImageStorage\ImageStorage;
use Illuminate\Support\Str;

final class CreateProductAction
{
    public function __construct(private ImageStorage $imageStorage)
    {
    }

    public function execute(ProductDto $dto): Product
    {
        $product = new Product();
        $product->id = (string) Str::uuid();
        $product->owner_id = $dto->owner_id;
        $product->title = $dto->title;
        $product->description = $dto->description;
        $product->price = $dto->price;
        $product->discount_type = $dto->discount_type;
        $product->discount = $dto->discount;
        $product->is_preorder = $dto->is_preorder;
        $product->images = $this->uploadImages($dto->images);

        $product->save();

        $product->categories()->attach($dto->category_id);

        return $product;
    }

    private function uploadImages(array $imagesToUpload): array
    {
        $images = [];
        foreach ($imagesToUpload as $image) {
            $images[] = sprintf('storage/%s', $this->imageStorage->upload($image));
        }

        return $images;
    }
}
