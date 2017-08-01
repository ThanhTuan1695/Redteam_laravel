<?php

namespace App\Http\Middleware;

use Closure;

class AfterLogin
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
        $response =  $next($request);
        dd($request->url());
        return $response;
    }
}
