<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;

class IsLogin
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
        /*if(Sentinel::check())
        {
            if($request->is("/"))
            {
                return redirect()->route("userList");
            }
            else
            {
                return $next($request);
            }
        }
        else
        {
            if($request->is("/"))
            {
                return $next($request);
            }
            else
            {
                return redirect()->route("login");
            }

        }*/
    }
}
