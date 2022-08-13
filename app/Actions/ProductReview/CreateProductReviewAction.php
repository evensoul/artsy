<?php

declare(strict_types=1);

namespace App\Actions\ProductReview;

use App\Dto\ProductReviewDto;
use App\Models\ProductReview;
use App\Service\ImageStorage\ImageStorage;
use Illuminate\Support\Str;

final class CreateProductReviewAction
{
    public function __construct(private ImageStorage $imageStorage) {}

    public function execute(ProductReviewDto $dto): ProductReview
    {
        $review = new ProductReview();
        $review->id = (string) Str::uuid();
        $review->product_id = $dto->product_id;
        $review->customer_id = $dto->customer_id;
        $review->body = $dto->body;
        $review->rating = $dto->rating;
        $review->images = $this->uploadImages($dto->images);
        $review->save();

        return $review;
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
