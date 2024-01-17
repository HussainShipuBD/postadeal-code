<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Config;
use Illuminate\Support\Facades\App;

class SetLocale
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

      if (session()->has('locale')) {
            App::setLocale(session()->get('locale'));
        }

        app()->setLocale(session('locale'));
        return $next($request);
    }
}
