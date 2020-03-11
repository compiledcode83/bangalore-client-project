<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class localization
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Check header request and determine localization
        $local = ($request->hasHeader('xLocalization')) ? $request->header('xLocalization') : 'en';
        // set laravel localization
        app()->setLocale($local);
        // continue request
        return $next($request);
    }
}
