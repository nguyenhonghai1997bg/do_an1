<?php

namespace App\Http\Middleware;

use Closure;

class AuthAdmin
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
        $currentUser = \Auth::user();
        if ($currentUser->role->name == 'User') {
            redirect()->route('home');
        }

        return $next($request);
    }
}
