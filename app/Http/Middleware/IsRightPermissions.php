<?php

namespace App\Http\Middleware;

use Closure;
use Redirect;
use App\Models\Util;
use Illuminate\Support\Facades\Auth;

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
        if(Auth::check())
        {
            $path = Util::strReplaceSlashToDot($request->route()->uri);
            $permissions = json_decode(Auth::user()->role->permissions, true);

            if (array_key_exists($path, $permissions))
            {
                return $next($request);
            }
            else
            {
                return Redirect::back()->withErrors('Permission denied');
            }
        }
        else
        {
            return $next($request);
        }

    }
}
