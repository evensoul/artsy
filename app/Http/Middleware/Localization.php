<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;

class Localization
{
    public function __construct(private Application $app, private Repository $config)
    {
    }

    public function handle(Request $request, Closure $next)
    {
        // read the language from the request header
        $locale = $request->header('X-Content-Language');

        // if the header is missed
        if(!$locale){
            // take the default local language
            $locale = $this->config->get('app.locale');
        }

        // check the languages defined is supported
        if (!in_array($locale, $this->config->get('app.supported_languages'), true)) {
            // respond with error
            return abort(403, 'Language not supported.');
        }

        // set the local language
        $this->app->setLocale($locale);

        // get the response after the request is done
        $response = $next($request);

        // set Content Languages header in the response
        $response->headers->set('X-Content-Language', $locale);

        return $response;
    }
}
