<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;
use Redirect;
use App\Models\Util;

class IsRightPermissions
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
        /*if(!$request->is("/"))
        {
            $path = Util::strReplaceSlashToDot($request->route()->uri);
            if (Sentinel::hasAccess($path))
            {
                return $next($request);
            }
            else
            {
                return Redirect::to('/')->withErrors('Permission denied');
            }
        }
        else
        {
            return $next($request);
        }*/

    }
}
