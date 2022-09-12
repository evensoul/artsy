<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\PaginationRequest;
use App\Http\Resources\FaqResource;
use App\Http\Resources\StaticPageResource;
use App\Models\Enums\StaticPageKey;
use App\Models\Faq;
use App\Models\StaticPage;
use Illuminate\Http\Resources\Json\JsonResource;

class StaticPageController
{
    public function faq(PaginationRequest $paginationRequest): JsonResource
    {
        $faqQuery = Faq::query()->orderBy('sort_order');

        return FaqResource::collection(
            $faqQuery->paginate(perPage: $paginationRequest->perPage, page: $paginationRequest->page)
        );
    }

    public function howWorks(): StaticPageResource
    {
        $page = StaticPage::query()->where('key', StaticPageKey::HOW_WORKS->value)->first();

        return new StaticPageResource($page);
    }

    public function safeShopping(): StaticPageResource
    {
        $page = StaticPage::query()->where('key', StaticPageKey::SAFE_SHOPPING->value)->first();

        return new StaticPageResource($page);
    }

    public function termsOfUse(): StaticPageResource
    {
        $page = StaticPage::query()->where('key', StaticPageKey::TERMS_OF_USE->value)->first();

        return new StaticPageResource($page);
    }

    public function confidentiality(): StaticPageResource
    {
        $page = StaticPage::query()->where('key', StaticPageKey::CONFIDENTIALITY->value)->first();

        return new StaticPageResource($page);
    }
}
