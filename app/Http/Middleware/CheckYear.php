<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Exceptions\InvalidReleasedYearException;

class CheckYear
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
        // get next year
        //get release year of film being added
        try {
            $nextYear = date('Y')+1;
            $releaseYear = $request->input('release_year');
            if ($releaseYear >= $nextYear) 
            {
                    throw new InvalidReleasedYearException; 
            }
        }
        catch (InvalidReleasedYearException $ex) {
            abort(500,$ex->message());
        }
               
        return $next($request);
    }
}
