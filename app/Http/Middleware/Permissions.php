<?php

namespace App\Http\Middleware;
use Closure;

class Permissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $roles)
    {
        $roles = explode('/', $roles);
        if(!in_array(auth()->user()->role, $roles)){
            return redirect()->route('not-permitted');
        }
        return $next($request);
    }
}