<?php

namespace Sijot\Http\Middleware;

use Closure;
use Illuminate\Foundation\Application;

/**
 * Class ApiLanguage.
 *
 * @author  Tim Joosten <Topairy@gmail.com>
 * @license MIT License
 * @package \Siçjot\Http\Middleware
 */
class ApiLanguage
{
    /**
     * The supported languages prefixes.
     *
     * @var array
     */
    protected static $supportedLanguages = ['nl', 'en', 'fr'];

    /**
     * Api Localization constructor. 
     *
     * @param  \Illuminate\Foundation\Application $app
     * @return void
     */
    public function __construct(Application $app) 
    {
        $this->app = $app;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Read the langauge form the request header.
        $locale = $request->header('Content-Language');

        if (! $locale) { // The header is missing 
            // Take the default local language
            $locale = $this->app->config->get('app.locale'); 
        } 

        // // Check if the language supported is supported. 
        // if (! array_key_exists($locale, self::$supportedLanguages)) {
        //    return abort(403, 'Language not supported'); // Respond with error.
        // }

        $this->app->setLocale($locale); // Set the local language. 

        $response = $next($request);                            // Get the response after the request is done. 
        $response->headers->set('Content-Language', $locale);   // set Content-Languages header in the response.

        return $response; // Return the response.
    }
}
