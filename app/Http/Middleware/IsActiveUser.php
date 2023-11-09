<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsActiveUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if (auth()->check() && !auth()->user()->is_active) {
            // If the user is not active, you can redirect them or show an error message.
            return redirect('/')->with('error', 'Your account is inactive.');
        }

        return $next($request);
    }
}
