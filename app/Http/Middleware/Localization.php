<?php

namespace App\Http\Middleware;

use Closure;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $raw_locale = \Session::get('locale');
        if(\Session::has('locale')){
            \App::setLocale($raw_locale);
        }
        return $next($request);
    }
}
