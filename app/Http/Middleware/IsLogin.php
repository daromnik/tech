<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

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
        if(Auth::check())
        {
            if($request->is("/"))
            {
                return redirect()->route("users.index");
            }
            else
            {
                return $next($request);
            }
        }
        else
        {
            if($request->is("/", "login"))
            {
                return $next($request);
            }
            else
            {
                return redirect()->route("login");
            }

        }
    }
}
