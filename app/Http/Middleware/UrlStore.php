<?php

namespace App\Http\Middleware;

use Closure;
use Route;
use Illuminate\Http\Request;

class UrlStore
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
        //    $url = \Request::getRequestUri();
        // $exploded = explode('/', $url);
        // $extension = explode('.', $exploded[count($exploded)-1]);
        // if(count($extension) <= 1){
        //     session()->put('intended',\Request::getRequestUri());
        // }
        session()->put('intendedurl',\Request::getRequestUri());
        return $next($request);
    }
}
