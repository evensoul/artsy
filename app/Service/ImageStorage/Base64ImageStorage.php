<?php

declare(strict_types=1);

namespace App\Service\ImageStorage;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Str;

class Base64ImageStorage implements ImageStorage
{
    public function __construct(private Filesystem $storage)
    {
    }

    public function upload(string $image): string
    {
        $extension = explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
        $replace = substr($image, 0, strpos($image, ',')+1);
        // find substring and replace here eg: data:image/png;base64,
        $image = str_replace($replace, '', $image);
        $image = str_replace(' ', '+', $image);
        $fileName = Str::random(10).'.'.$extension;

        $this->storage->put($fileName, base64_decode($image));

        return $fileName;
    }
}
