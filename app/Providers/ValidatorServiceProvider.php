<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class ValidatorServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Validator::extend('base64max', 'App\Validator\Base64Validator@validateBase64Max');
        Validator::extend('base64min', 'App\Validator\Base64Validator@validateBase64Min');
        Validator::extend('base64dimensions', 'App\Validator\Base64Validator@validateBase64Dimensions');
        Validator::extend('base64file', 'App\Validator\Base64Validator@validateBase64File');
        Validator::extend('base64image', 'App\Validator\Base64Validator@validateBase64Image');
        Validator::extend('base64mimetypes', 'App\Validator\Base64Validator@validateBase64Mimetypes');
        Validator::extend('base64mimes', 'App\Validator\Base64Validator@validateBase64Mimes');
        Validator::extend('base64between', 'App\Validator\Base64Validator@validateBase64Between');
        Validator::extend('base64size', 'App\Validator\Base64Validator@validateBase64Size');
    }
}
