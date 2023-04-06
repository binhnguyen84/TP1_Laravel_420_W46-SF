<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminFilm
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->role->name != 'admin'||!$request->user()->tokenCan('film::post','film::delete')) {
            abort(403,"Non Authorisé");
        }
        
        return $next($request);
    }
}
